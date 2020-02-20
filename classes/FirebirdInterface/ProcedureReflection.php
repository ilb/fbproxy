<?php

class FirebirdInterface_ProcedureReflection {

    public function getProcedureName($interface, $method = "execute") {
        $class = new ReflectionClass($interface);
        $docComment = $this->getInterfaceDocBlock($class, $interface, $method);
        $docCommentParams = $this->getParams($docComment);
        return $docCommentParams['@fbprocedure'];
    }

    private function getInterfaceDocBlock(ReflectionClass $class, $interface, $method) {
        $this->interfaceHaveMethod($class, $interface, $method);
        $method = $class->getMethod($method);
        return $method->getDocComment();
    }

    private function getParams($docComment) {
        $docComment = new CodeGen_DocBlockParser($docComment);
        return $docComment->params;
    }

    private function interfaceHaveMethod(ReflectionClass $class, $interface, $method) {
        if (!$class->isInterface()) {
            throw new Exception("Class {$interface} must be an interface.");
        }
        if (!$class->hasMethod($method)) {
            throw new Exception("Interface {$interface} must have a method {$method}.");
        }
    }

}
