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

        // Instantiate a Project Object.
        $this->project = new PortfolioProject();

        // Instantiate an std Object.
        $this->response = new stdClass;

        // Instantiate an std Object.
        $counts = new stdClass;

        // Count all projects.
        $counts->all = $this->project->count_rows();
        $counts->published = $this->project->count_rows('published');
        $counts->trash = $this->project->count_rows('trash');
        $counts->draft = $this->project->count_rows('draft');

        $this->response->counts = $counts;

    }

    public function search(array $data)
    {        
        $keyword = (!empty($data['keyword'])) ? clean_data($data['keyword']) : '';
        
        $this->response->projects = $this->project->search($keyword);

        return $this->response;
    }

    public function get(int $id = null)
    {        
        if (empty($id)) {
            $this->response->projects = $this->project->get_all();
        } else {
            $this->project->id = clean_data($id);
            $this->response->project = $this->project->get();
        }

        return $this->response;
    }

    public function get_pulished()
    {
        $this->response->projects = $this->project->get_by_status('published');

        return $this->response;
    }

    public function get_trash()
    {
        $this->response->projects = $this->project->get_by_status('trash');

        return $this->response;
    }

    public function get_draft()
    {
        $this->response->projects = $this->project->get_by_status('draft');

        return $this->response;
    }

    public function process_data(array $data): object
    {
        if (empty($data['title'])) {
            $this->response->error = true;
            $this->response->message = 'Please enter the title of your project.';
            $this->response->type = 'title';
            $this->response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } elseif (empty($data['description'])) {
            $this->response->error = true;
            $this->response->message = 'Please write at least a short note about the your project.';
            $this->response->type = 'description';
            $this->response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } elseif (empty($data['featured-image'])) {
            $this->response->error = true;
            $this->response->message = 'You need to set a featured image for your project.';
            $this->response->type = 'featured-image';
            $this->response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } elseif (!filter_var($data['featured-image'], FILTER_VALIDATE_URL)) {
            $this->response->error = true;
            $this->response->message = 'Invalide link to the featured image.';
            $this->response->type = 'featured-image';
            $this->response->filled_data = [
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
                        $this->response->error = false;
                        $this->response->message = 'Creaeted successfully';
                        $this->response->type = null;
                        $this->response->filled_data = [];
                    }
                }
            }
        }

        return $this->response;
    }

    public function update(array $data)
    {
        // Set data.
        $this->project->id = (int) clean_data($data['id']);
        $this->project->title = (string) clean_data($data['title']);
        $this->project->content = (string) clean_data($data['description']);
        $this->project->comment_status = (string) (!empty($data['comments'])) ? 'open' : 'close';

        if (!filter_var($data['featured-image'], FILTER_VALIDATE_URL)) {
            $this->response->error = true;
            $this->response->message = 'Invalide link to the featured image.';
            $this->response->type = 'featured-image';
            $this->response->filled_data = [
                'title' => $data['title'], 
                'description' => $data['description'], 
                'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                'featured-image' => $data['featured-image'],
                'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
            ];
        } else {
            // Set the featured image of the project. 
            $this->project->featured_image = (string) clean_data($data['featured-image']);

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
                    if (!$category_obj->is_project_added($category_obj->id, $this->project->id)) {
                        // Add the project to the category.
                        $category_obj->add_project($category_obj->id, $this->project->id);
                    }

                    // Create a list of all the categorys that has been added.`
                    array_push($cat_ids, $category_obj->id);
                }

                // Check if the prject is uncategorized.
                if ($key = array_search(42, $cat_ids)) {
                    unset($cat_ids[$key]);
                }

                // Remove categories that has been unchecked.
                $category_obj->remove_project($cat_ids, $this->project->id);
            } else {
                // Instantiate a Category Object.
                $category_obj = new Category;

                // Remove all category that has been unchecked.
                $category_obj->remove_project($cat_ids, $this->project->id);

                // Check if the project has been uncategorized.
                if (!$category_obj->is_project_added(42, $this->project->id)) {
                    // Uncategorized the project.
                    $category_obj->add_project(42, $this->project->id);
                }
            }

            // Update the project.
            if (!$this->project->update()) {
                $this->response->id = clean_data($data['id']);
                $this->response->error = true;
                $this->response->message = 'Sorry, something went wrong when tring to update the project.';
                $this->response->type = 'project update failed';
                $this->response->filled_data = [
                    'title' => $data['title'], 
                    'description' => $data['description'], 
                    'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                    'featured-image' => $data['featured-image'],
                    'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
                ];
            } else {
                $this->response->id = clean_data($data['id']);
                $this->response->error = false;
                $this->response->message = "
                Updated successfully. 
                Click <a class='alert-link' href='". WEB_ROOT. "admin/projects'>here</a> 
                to go back to the projects";
                $this->response->type = null;
                $this->response->filled_data = [
                    'title' => $data['title'], 
                    'description' => $data['description'], 
                    'categories' => (!empty($data['categories'])) ? $data['categories'] : ['uncategorized'],
                    'featured-image' => $data['featured-image'],
                    'open-comment' => (!empty($data['comments'])) ? 'open' : 'close'
                ];
            }
        }
        

        return $this->response;
    }

    public function make_string(
        array $data,
        string $delimiter
    ): string
    {
        return implode($delimiter, $data);
    }
}
