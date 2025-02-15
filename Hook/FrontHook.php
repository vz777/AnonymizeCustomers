<?php

namespace AnonymizeCustomers\Hook;

use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class FrontHook extends BaseHook
{
    public function onAccountAdditional(HookRenderBlockEvent $event): void
    {
        $event->add([
            'id' => 'account-support',
            'title' => 'Suppression du compte',
            'content' => $this->render('account-additional.html')
        ]);
    }

    public function onAccountTop(HookRenderEvent $event): void
    {
        $content = $this->render('account-top.html');
        $event->add($content);
    }
}
