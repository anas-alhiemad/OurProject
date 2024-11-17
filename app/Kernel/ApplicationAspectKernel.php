<?php

namespace App\Kernel;

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use App\Aspects\FileUploadAspect;

class ApplicationAspectKernel extends AspectKernel
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configureAop(AspectContainer $container)
    {
        $container->registerAspect(new FileUploadAspect());
    }

    public function boot()
    {
        // Perform any necessary bootstrapping here
    }
}
