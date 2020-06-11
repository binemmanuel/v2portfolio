<?php
namespace model;

use portfolio\BaseModel;
use portfolio\Category;
use portfolio\Project as PortfolioProject;
use stdClass;

use function portfolio\clean_data;

class Project extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function get(int $id = null)
    {
        $project = new PortfolioProject();
        
        if (empty($id)) {
            $response = $project->get_all();
        } else {
            $project->id = clean_data($id);
            $response = $project->get();
        }

        return $response;
    }

    public function process_data(array $data): object
    {
        // Initalize an std Class
        $response = new stdClass;

        if (empty($data['title'])) {
            $response->error = true;
            $response->message = 'Please enter the title of your project.';
            $response->type = 'title';
            $response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } elseif (empty($data['description'])) {
            $response->error = true;
            $response->message = 'Please write at least a short note about the your project.';
            $response->type = 'description';
            $response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } elseif (empty($data['featured-image'])) {
            $response->error = true;
            $response->message = 'You need to set a featured image for your project.';
            $response->type = 'featured-image';
            $response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } elseif (!filter_var($data['featured-image'], FILTER_VALIDATE_URL)) {
            $response->error = true;
            $response->message = 'Invalide link to the featured image.';
            $response->type = 'featured-image';
            $response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } else {
            // store data.
            $title = (string) clean_data($data['title']);
            $description = (string) clean_data($data['description']);
            $featured_image = (string) clean_data($data['featured-image']);
            $status = (string) clean_data($data['status']);
            $comment_status = (string) (!empty($data['comments'])) ? 'open' : 'close';
            
            if (!empty($data['categories'])) {
                $categories = (array)  $data['categories'];
            } else {
                $categories = (array)  ['uncategorized'];
            }

            // Instantiate a Project Object.`
            $project = new PortfolioProject;

            // Set data.
            $project->title = $title;
            $project->content= $description;
            $project->author= 'Bin Emmanuel';
            $project->categories = $categories;
            $project->featured_image = $featured_image;
            $project->status = strtolower($status);
            $project->comment_status = $comment_status;

            // Save the project.
            $project->id = $project->save();

            if (!empty($project->id)) {
                // Instantiate a Category Object.
                $category_obj = new Category;
    
                // Loop through the list of categories.
                foreach ($categories as $category) {
                    // Set data.
                    $category_obj->name = clean_data($category);
                    
                    // Check if the category already exist.
                    // If it does then theres absolutely no need
                    // to insert it into the database.
                    $category_obj->id = $category_obj->exists($category_obj->name);
                    if (empty($category_obj->id)) {
                        // Create a slug for the category.
                        $category_obj->make_slug($category);
        
                        // Save the category
                        $category_obj->id = $category_obj->save();
                    }

                    // Add project the categories.
                    if ($category_obj->add_project(
                        $category_obj->id,
                        $project->id
                    )) {
                        $response->error = false;
                        $response->message = 'Creaeted successfully';
                        $response->type = null;
                        $response->filled_data = [];
                    }
                }
            }
        }

        return $response;
    }

    public function update(array $data)
    {
        // Instantiate a Project Object.
        $project = new PortfolioProject;

        // Initalize an std Class.
        $response = new stdClass;

        // Set data.
        $project->id = (int) clean_data($data['id']);
        $project->title = (string) clean_data($data['title']);
        $project->content = (string) clean_data($data['description']);
        $project->comment_status = (string) (!empty($data['comments'])) ? 'open' : 'close';

        if (!filter_var($data['featured-image'], FILTER_VALIDATE_URL)) {
            $response->error = true;
            $response->message = 'Invalide link to the featured image.';
            $response->type = 'featured-image';
            $response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } else {
            // Set the featured image of the project. 
            $project->featured_image = (string) clean_data($data['featured-image']);

            // Instantiate an empty array.
            $cat_ids = [];

            if (!empty($data['categories'])) {
                $categories = (array)  $data['categories'];

                // Loop through the list of categories.
                foreach ($categories as $category) {
                    // Instantiate a Category Object.
                    $category_obj = new Category;
                    $category_obj->id = $category_obj->exists($category);

                    // Check if the project hasn't been added to a category.
                    if (!$category_obj->is_project_added($category_obj->id, $project->id)) {
                        // Add the project to the category.
                        $category_obj->add_project($category_obj->id, $project->id);
                    }

                    // Create a list of all the categorys that has been added.`
                    array_push($cat_ids, $category_obj->id);
                }

                // Check if the prject is uncategorized.
                if ($key = array_search(42, $cat_ids)) {
                    unset($cat_ids[$key]);
                }

                // Remove categories that has been unchecked.
                $category_obj->remove_project($cat_ids, $project->id);
            } else {
                // Instantiate a Category Object.
                $category_obj = new Category;

                // Remove all category that has been unchecked.
                $category_obj->remove_project($cat_ids, $project->id);

                // Check if the project has been uncategorized.
                if (!$category_obj->is_project_added(42, $project->id)) {
                    // Uncategorized the project.
                    $category_obj->add_project(42, $project->id);
                }
            }

            // Update the project.
            if (!$project->update()) {
                $response->id = clean_data($data['id']);
                $response->error = true;
                $response->message = 'Sorry, something went wrong when tring to update the project.';
                $response->type = 'project update failed';
                $response->filled_data = [
                    'title' => $data['title'], 
                    'description' => $data['description'], 
                    'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                    'featured-image' => $data['featured-image'],
                    'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
                ];
            } else {
                $response->id = clean_data($data['id']);
                $response->error = false;
                $response->message = "
                Updated successfully. 
                Click <a class='alert-link' href='". WEB_ROOT. "admin/projects'>here</a> 
                to go back to the projects";
                $response->type = null;
                $response->filled_data = [
                    'title' => $data['title'], 
                    'description' => $data['description'], 
                    'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                    'featured-image' => $data['featured-image'],
                    'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
                ];
            }
        }
        

        return $response;
    }

    public function make_string(
        array $data,
        string $delimiter
    ): string
    {
        return implode($delimiter, $data);
    }
}
