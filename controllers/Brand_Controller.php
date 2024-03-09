<?php
class Brand_Controller
{
    private $brand_model;

    public function __construct(Brand_Model $brand_model)
    {
        $this->brand_model = $brand_model;
    }

    public function get_brands_skills()
    {
        $resutlt = $this->brand_model->get_brands_skills();

        echo $resutlt;
    }

    public function get_all_data()
    {
        $resutlt = $this->brand_model->get_all_data();

        echo $resutlt;
    }

    public function update_brand($data)
    {
        $resutlt = $this->brand_model->update_brand($data);

        echo $resutlt;
    }

    public function update_brand_img($id, $file)
    {
        $resutlt = $this->brand_model->update_brand_img($id, $file);

        echo $resutlt;
    }

    public function brands_info()
    {
        $resutlt = $this->brand_model->brands_info();

        echo $resutlt;
    }
}
