<?php

namespace App\Http\Requests;

class UpdateSiteRequest extends StoreSiteRequest
{
    public function authorize()
    {
        // same authorization as store
        return $this->user() && $this->user()->isAdmin;
    }

    public function rules()
    {
        return parent::rules();
    }
}
