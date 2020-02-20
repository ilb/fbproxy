<?php

class FirebirdInterface_Proxy {

    /**
     * @var FirebirdInterface_FirebirdMapper
     */
    public $firebirdMapper;

    /**
     * @var FirebirdInterface_FBReflection
     */
    public $fbReflection;

    /**
     * FirebirdInterface_Proxy constructor.
     * @param PDO $pdo
     * @throws ReflectionException
     */
    public function __construct(PDO $pdo) {
        $this->firebirdMapper = new FirebirdInterface_FirebirdMapper($pdo);
        $this->fbReflection = new FirebirdInterface_FBReflection(FirebirdInterface_FirebirdInterface::class);
    }

    /**
     * @param string $fbprocedureName Название процедуры
     * @param array $arguments Аргумент должен иметь вид: [":FIELDNAME" => 'value', ...]
     * @return mixed
     * @throws Exception
     */
    public function __call($fbprocedureName, array $data) {
        if (!isset($data[0])) {
            throw new InvalidArgumentException("Missing argument");
        }
        $this->fbReflection->getInterfaceDocBlock($fbprocedureName);
        $fbprocedure = $this->fbReflection->getProcedureName();
        $isFindAll = $this->fbReflection->isFindAll();

        return $this->firebirdMapper->execute($fbprocedure, $data[0], $isFindAll);
    }

}
