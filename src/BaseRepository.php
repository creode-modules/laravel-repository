<?php

namespace Creode\LaravelRepository;

/**
 * Class BaseRepository
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
abstract class BaseRepository {
    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $modelClass = $this->getModel();
        $this->model = new $modelClass;
    }

    /**
     * Gets the model class name.
     *
     * @return string
     */
    abstract function getModel(): string;

    /**
     * PHP Magic method which will pass any method calls to the model.
     *
     * @param string $method
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        // Check if the method exists in the current class
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }

        $modelClassName = $this->getModel();

        // Check if the method exists in the model class
        // and if it's static, it will be called statically
        if (method_exists($modelClassName, $method)) {
            return call_user_func_array([$modelClassName, $method], $arguments);
        }

        // If the method is non-static, we would need to instantiate the model
        if (is_callable([$modelClassName, $method])) {
            $modelInstance = new $modelClassName();
            return call_user_func_array([$modelInstance, $method], $arguments);
        }

        throw new \BadMethodCallException("Method {$method} does not exist on " . get_class($this) . " or " . $modelClassName);
    }
}
