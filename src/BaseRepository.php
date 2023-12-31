<?php

namespace Creode\LaravelRepository;

/**
 * Class BaseRepository
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
abstract class BaseRepository
{
    /**
     * Gets the model class name.
     *
     * @return string
     */
    abstract protected function getModel(): string;

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

        // If the method is non-static, we would need to instantiate the model
        if (is_callable([$modelClassName, $method])) {
            $modelInstance = new $modelClassName();
            return call_user_func_array([$modelInstance, $method], $arguments);
        }

        throw new \BadMethodCallException("Method {$method} does not exist on " . get_class($this) . " or " . $modelClassName);
    }

    /**
     * Handle dynamic static method calls into the repository.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return (new static)->__call($method, $arguments);
    }
}
