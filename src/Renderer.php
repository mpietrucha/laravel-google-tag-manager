<?php

namespace Mpietrucha\GoogleTagManager;

use Mpietrucha\GoogleTagManager\GoogleTagManager;

class Renderer
{
    protected string $view;

    public function __construct(protected GoogleTagManager $googleTagManager)
    {
    }

    public function render(string $view): self
    {
        $this->view = config('google-tag-manager.viewKey').'::'.$view;

        return $this;
    }

    public function with(?string $nonce = null): string
    {
        return view($this->view, [
            'nonce' => $this->nonce($nonce),
            'enabled' => $this->googleTagManager->enabled(),
            'id' => $this->googleTagManager->id(),
            'pushData' => $this->googleTagManager->getPushData(),
            'dataLayer' => $this->googleTagManager->dataLayer()
        ]);
    }

    protected function nonce(?string $nonce): string
    {
        if (! $nonce) {
            return '';
        }

        return ' nonce="'. $nonce .'"';
    }
}
