<?php

/**
 * Извлевает из интерфейса docBlock комментарий
 * Class FirebirdInterface_FBReflection
 */
class FirebirdInterface_FBReflection {

    /**
     * Параметры DocBlock комментарий
     * @var array
     */
    private $params;

    /**
     * @var ReflectionClass
     */
    private $reflectionClass;

    /**
     * FirebirdInterface_FBReflection constructor.
     * @param $reflectionClass
     * @throws ReflectionException
     */
    public function __construct($reflectionClass) {
        $this->reflectionClass = new ReflectionClass($reflectionClass);
    }

    /**
     * @return mixed
     */
    public function getProcedureName() {
        return $this->params['@fbprocedure'];
    }

    /**
     * @return mixed
     */
    public function isFindAll() {
        return isset($this->params['@return']) ? true : false;
    }

    /**
     * @param $method
     * @throws ReflectionException
     */
    public function getInterfaceDocBlock($method) {
        $this->interfaceIsHaveMethod($method);
        $method = $this->reflectionClass->getMethod($method);
        $params = $this->getParams($method->getDocComment());
        $this->setParams($params);
    }

    /**
     * @param $method
     * @throws Exception
     */
    private function interfaceIsHaveMethod($method) {
        if (!$this->reflectionClass->isInterface()) {
            throw new Exception("Class must be an interface.");
        }
        if (!$this->reflectionClass->hasMethod($method)) {
            throw new Exception("Interface must have a method {$method}.");
        }
    }

    /**
     * @param $docblock
     * @return array
     */
    private function getParams($docblock) {
        $docComment = new CodeGen_DocBlockParser($docblock);
        return $docComment->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params) {
        $this->params = $params;
    }

}
