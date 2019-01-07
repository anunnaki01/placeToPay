<?php

namespace App\Services;

class PseValidate
{
    const RETURN_CODE_SUCCES = 'SUCCESS';

    public function getRequiereInputs()
    {
        return [
            'paymentMethod' => 'required',
            'bankInterface' => 'required',
            'bankCode' => 'required',
            'document' => 'required',
            'documentType' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'company' => 'required',
            'emailAddress' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'mobile' => 'required',
        ];
    }

    public function getMessageInputs()
    {
        return [
            'paymentMethod.required' => 'El campo Medio de Pago es obligatorio.',
            'bankInterface.required' => 'El campo Tipo de Cliente es obligatorio.',
            'bankCode.required' => 'El campo Entidad Bancaria es obligatorio.',
            'document.required' => 'El campo Documento es obligatorio.',
            'documentType.required' => 'El campo Tipo de Documento es obligatorio.',
            'firstName.required' => 'El campo Nombre es obligatorio.',
            'lastName.required' => 'El campo Apellido es obligatorio.',
            'company.required' => 'El campo Compañía es obligatorio.',
            'emailAddress.required' => 'El campo Correo Electronico es obligatorio.',
            'address.required' => 'El campo Dirección es obligatorio.',
            'city.required' => 'El campo Ciudad es obligatorio.',
            'province.required' => 'El campo Departamento es obligatorio.',
            'country.required' => 'El campo País es obligatorio.',
            'phone.required' => 'El campo Telefono es obligatorio.',
            'mobile.required' => 'El campo Celular es obligatorio.',
        ];
    }

    public function validateInputs()
    {
        return request()->validate($this->getRequiereInputs(), $this->getMessageInputs());
    }

    public function validateReturnCode($returnCode)
    {
        return (self::RETURN_CODE_SUCCES == $returnCode);
    }
}