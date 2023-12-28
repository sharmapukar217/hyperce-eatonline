<?php

namespace Hyperce\EatOnline\FormWidgets;

use Admin\Classes\FormField;
use Admin\Traits\ValidatesForm;
use Admin\Classes\BaseFormWidget;
use Admin\Traits\FormModelWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Igniter\Flame\Exception\ApplicationException;

/**
 * Map Area
 */
class ListForm extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    const SORT_PREFIX = '___dragged_';

    //
    // Configurable properties
    //

    public $form;
    public $fieldName;

    public $modelClass;

    public $prompt = 'Add new';

    public $sortColumnName = 'priority';

    public $sortable = true;

    public $addLimit = INF;
    //
    // Object properties
    //

    protected $defaultAlias = 'listform';

    protected $records;
    protected $formWidget;
    protected $sortableInputName;



    public function initialize()
    {
        $this->configPath[] = "$/hyperce/eatonline";

        $this->fillFromConfig([
            'form',
            'prompt',
            'toolbar',
            'modelClass',
            'addLimit',

            'addLabel',
            'sortable',
        ]);

        $this->fieldName = $this->formField->getName(false);
        $this->sortableInputName = self::SORT_PREFIX . $this->fieldName;
    }

    public function loadAssets()
    {
        $this->addJs('js/listform.js');
    }

    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('listform/index');
    }

    public function prepareVars()
    {
        $records = $this->getRecords();

        $this->vars['field'] = $this->formField;
        $this->vars['fieldName'] = $this->fieldName;
        
        $this->vars['sortable'] = $this->sortable;
        $this->vars['sortableInputName'] = $this->sortableInputName;

        $this->vars['records'] = $records;
        $this->vars['recordCount'] = count($records);

        $this->vars['prompt'] = $this->prompt;
        $this->vars['addLimit'] = $this->addLimit;
    }

    protected function getRecords()
    {
        // load value of the fields defined on [form][fields]
        $loadValue = $this->getLoadValue();

        // convert collection to array
        if ($loadValue instanceof Collection)
            $loadValue = $loadValue->toArray();

        // if sorting enabled, sot based on $sortColumnName
        if ($this->sortable)
            $loadValue = sort_array($loadValue, $this->sortColumnName);


        $result = [];

        foreach ($loadValue as $key => $area) {
            $result[$key] = (object) $area;
        }

        return $result;
    }

    public function onLoadRecord()
    {
        $model = strlen($recordId = post('recordId'))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        return $this->makePartial('listform/form', [
            'formTitle' => ($model->exists ? "Edit" : "Add") . ' ' . lang($this->fieldName),
            'formWidget' => $this->makeRecordFormWidget($model),
        ]);
    }

    public function getSaveValue($value)
    {
        if (!$this->sortable)
            return FormField::NO_SAVE_DATA;

        $items = $this->formField->value;
        if (!$items instanceof Collection)
            return $items;

        $sortedIndexes = (array) post($this->sortableInputName);
        $sortedIndexes = array_flip($sortedIndexes);

        $value = [];
        foreach ($items as $index => $item) {
            $value[$index] = [
                $item->getKeyName() => $item->getKey(),
                $this->sortColumnName => $sortedIndexes[$item->getKey()],
            ];
        }

        return $value;
    }

    public function onSaveRecord()
    {
        $model = strlen($recordId = post('id'))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        $context = $recordId ? "edit" : "create";

        $form = $this->makeRecordFormWidget($model, $context);

        // check if new record can be created ( when limit is set )
        if ($context === "create" && $this->addLimit !== INF) {
            $total = $model->where("location_id", post("location_id"))->count();
            if ($total >= $this->addLimit) {
                $this->prepareVars();

                flash()->error(sprintf(lang('admin::lang.alert_error'),
                    sprintf(lang('hyperce.eatonline::default.error_record_limit_reached'), $this->addLimit, $this->fieldName)
                ))->now();

                return [
                    '#notification' => $this->makePartial('flash'),
                    '.records-count' => $this->makePartial('listform/counts'),
                    '.record-toolbar' => $this->makePartial('listform/toolbar'),
                    '.record-container' => $this->makePartial('listform/records'),
                ];
            }
        }

        $this->validateFormWidget($form, $saveData = $form->getSaveData());
        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function () use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });


        flash()->success(sprintf(lang('admin::lang.alert_success'),
            lang($this->fieldName) . ' ' . ($form->context == 'create' ? 'created' : 'updated')
        ))->now();

        $this->formField->value = null;
        $this->model->reloadRelations();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '.records-count' => $this->makePartial('listform/counts'),
            '.record-toolbar' => $this->makePartial('listform/toolbar'),
            '.record-container' => $this->makePartial('listform/records'),
        ];
    }

    public function onDeleteRecord()
    {

        if (!strlen($recordId = post('recordId')))
            throw new ApplicationException(
                sprintf(lang('hyperce.eatonline::default.error_no_record'), $this->fieldName));

        $model = $this->getRelationModel()->find($recordId);
        if (!$model)
            throw new ApplicationException(sprintf(lang('admin::lang.form.not_found'), $recordId));

        $model->delete();

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($this->fieldName) . ' deleted'))->now();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '.records-count' => $this->makePartial('listform/counts'),
            '.record-toolbar' => $this->makePartial('listform/toolbar'),
        ];
    }

    protected function makeRecordFormWidget($model, $context = null)
    {
        if (is_null($context))
            $context = $model->exists ? 'edit' : 'create';

        if (is_null($model->location_id))
            $model->location_id = $this->model->getKey();


        if (is_string($this->form))
            $config = $this->loadConfig($this->form, ['form'], 'form');
        else
            $config = $this->form;

        $config['model'] = $model;
        $config['context'] = $context;
        $config['alias'] = $this->alias . 'Form';

        $widget = $this->makeWidget('Admin\Widgets\Form', $config);
        $widget->bindToController();

        return $this->formWidget = $widget;
    }
}
