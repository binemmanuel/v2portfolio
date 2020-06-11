<?php
namespace model;

use portfolio\BaseModel;
use portfolio\Category as PortfolioCategory;
use stdClass;

use function portfolio\clean_data;

class Category extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $category = new PortfolioCategory;
        
        $response = $category->get_all(0, 2000000);

        return $response;
    }

    public function get(int $id = null)
    {
        $category = new PortfolioCategory($id);
        
        $response = $category->get();

        return $response;
    }

    public function process_data(array $data)
    {
        // Instantiate a Category Object.
        $category = new PortfolioCategory;

        // Initalize an std Class.
        $response = new stdClass;

        // Process data.
        if (empty($data['name'])) {
            $response->error = true;
            $response->message = 'You need to enter the name of the category you want to add.';
            $response->error_type = 'name';
            $response->filled_data = [
                'name' => $data['name'],
                'description' => $data['description'],
                'slug' => $data['slug']
            ];
        } else {
            // Set data.
            $category->name = clean_data($data['name']);
            $category->slug = (string) (!empty($data['slug'])) ? clean_data($data['slug']) : $category->make_slug($category->name);
            $category->description = clean_data($data['description']);

            // Save the category.
            if ($category->exists($category->name)) {
                $response->error = true;
                $response->message = 'The category you are tring to add already exist.';
                $response->error_type = 'add category failed';
                $response->filled_data = [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'slug' => $data['slug']
                ];
            } elseif (!$category->save()) {
                $response->error = true;
                $response->message = 'Something went wrong when tring to save the category.';
                $response->error_type = 'add category failed';
                $response->filled_data = [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'slug' => $data['slug']
                ];
            } else {
                $response->error = false;
                $response->message = 'The category has been added successfully.';
                $response->error_type = null;
                $response->filled_data = [];
            }
        }

        return $response;
    }
    public function update(array $data): object
    {
        // Instantiate a Category Object.
        $category = new PortfolioCategory;

        // Instantate an std Object.
        $response = new stdClass;

        // Process data.
        if (empty($data['name'])) {
            $response->error = true;
            $response->message = 'You need to enter the name of the category you want to add.';
            $response->error_type = 'name';
            $response->filled_data = [
                'name' => $data['name'],
                'description' => $data['description'],
                'slug' => $data['slug']
            ];
        } else {
            // Set data.
            $category->id = clean_data($data['id']);
            $category->name = clean_data($data['name']);
            $category->slug = (string) (!empty($data['slug'])) ? clean_data($data['slug']) : $category->make_slug($category->name);
            $category->description = clean_data($data['description']);

            // Update the category.
            if (!$category->update()) {
                $response->error = true;
                $response->message = 'Something went wrong when tring to update the category.';
                $response->error_type = 'add category failed';
                $response->filled_data = [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'slug' => $data['slug']
                ];
            } else {
                $response->error = false;
                $response->message = 'The category has been updated successfully.';
                $response->error_type = null;
                $response->filled_data = [];
            }
        }

        return $response;
    }
}
