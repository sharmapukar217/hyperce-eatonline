<?php

namespace Hyperce\EatOnline\Components;

class Link extends \System\Classes\BaseComponent
{
    public function onRun()
    {
        $this->page['id'] = $this->property('id', null);
        $this->page['href'] = $this->property('href');
        $this->page['class'] = $this->property('class');
        $this->page['target'] = $this->property('target');
        $this->page['iconClass'] = $this->property('icon-class');
    }

    public function defineProperties()
    {
        return [
            'id' => [],
            'class' => [],
            'target' => [],
            'icon-class' => [],
            'href' => ['type' => 'text'],
        ];
    }
}
