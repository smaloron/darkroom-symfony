<?php

namespace Darkroom\ModelBundle\FormHandler;

interface FormHandlerInterface
{
    public function getForm();

    public function process($entity = null);

    public function onSuccess($entity);
}