<?php

namespace App\Services;

use Smarty\Smarty;

class SmartyRenderer
{
    private Smarty $engine;

    public function __construct()
    {
        $this->engine = new Smarty();
        $this->engine->setTemplateDir(resource_path('smarty/templates'));
        $this->engine->setCompileDir(storage_path('framework/smarty/compile'));
        $this->engine->setCacheDir(storage_path('framework/smarty/cache'));
        $this->engine->setCaching(Smarty::CACHING_OFF);
    }

    public function render(string $template, array $data = []): string
    {
        $this->engine->clearAllAssign();

        foreach ($data as $key => $value) {
            $this->engine->assign($key, $value);
        }

        return $this->engine->fetch($template);
    }
}
