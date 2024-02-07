<?php
/**
 *  Copyright (c) 2018 Webbing Brasil (http://www.webbingbrasil.com.br)
 *  All Rights Reserved
 *
 *  This file is part of the calculadora-triunfo project.
 *
 *  @project calculadora-triunfo
 *  @file CanBeInherited.php
 *  @author Danilo Andrade <danilo@webbingbrasil.com.br>
 *  @date 10/08/18 at 18:13
 *  @copyright  Copyright (c) 2018 Webbing Brasil (http://www.webbingbrasil.com.br)
 */

/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 09/08/2018
 * Time: 18:10
 */

namespace WebbingBrasil\EloquentSTI;

use Illuminate\Support\Str;
use ReflectionClass;

/**
 * Trait CanBeInherited
 * @package WebbingBrasil\EloquentSTI
 */
trait CanBeInherited
{
    /**
     * Check that model has inheritance
     *
     * @return bool
     */
    public function hasInheritance()
    {
        return (get_parent_class($this) != static::class) && is_subclass_of($this, self::class);
    }

    /**
     * Get table name from object property or from parent class
     *
     * @return string
     */
    public function getTable()
    {
        if (!isset($this->table) && $this->hasInheritance()) {
            return str_replace('\\', '', Str::snake(Str::plural($this->getParentClassName())));
        }

        return parent::getTable();
    }

    public function getForeignKey()
    {
        return Str::snake($this->getParentClassName()).'_'.$this->primaryKey;
    }

    public function joiningTable($related)
    {
        $relatedClassName = method_exists((new $related), 'getParentClassName')
            ? (new $related)->getParentClassName()
            : class_basename($related);
        $models = [
            Str::snake($relatedClassName),
            Str::snake($this->getParentClassName()),
        ];
        sort($models);
        return strtolower(implode('_', $models));
    }

    public function getParentClassName()
    {
        return class_basename(self::class);
    }
}
