<?php
namespace model;

use portfolio\BaseModel;
use portfolio\Tag as PortfolioTag;

use function portfolio\clean_data;

class Tag extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function get(int $id = null)
    {
        $tag = new PortfolioTag($id);
        
        $response = $tag->get_all(0, 2000000);

        return $response;
    }
}
