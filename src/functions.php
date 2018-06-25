<?php declare(strict_types=1);

namespace WyriHaximus;

use Cake\Collection\Collection;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use WyriHaximus\Annotations\ChildProcess;

function toChildProcessOrNotToChildProcess(string $callable, Reader $annotationReader = null): bool
{
    if (!($annotationReader instanceof Reader)) {
        $annotationReader = new AnnotationReader();
    }

    list($class, $method) = explode('::', $callable);

    $annotations = (new  Collection($annotationReader->getMethodAnnotations((new \ReflectionClass($class))->getMethod($method))))
        ->indexBy(function (object $annotation) {
            return get_class($annotation);
        })->toArray();

    if (!isset($annotations[ChildProcess::class])) {
        return false;
    }

    return true;
}
