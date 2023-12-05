<?php

namespace Hyperce\EatOnline\Components;

class LocalBox extends \Igniter\Local\Components\LocalBox
{
    public function onRun()
    {
        parent::onRun();
        $this->page['ebee_website'] = $this->location->current()->ebee_website;
    }
}
