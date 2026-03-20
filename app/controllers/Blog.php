<?php

/**
 * Blog controller
 */

class Blog
{
    use Controller;

    public function index()
    {
        $data = [];
        $appData = new App;
        $allBlogStories = $appData->sch_blog();
        if ($allBlogStories) {
            $data['blogStories'] = $allBlogStories;
        }
        $this->view('Blog', $data, __FUNCTION__);
    }

    public function create()
    {
        $appData = new App;
        $blogModel = new BlogModel;
        $schToken = $appData->schoolToken;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($blogModel->validate($_POST)) {
                if ($_FILES['blog_image']['size'] > 0) {
                    $blogKey = smartKey($schToken . " " . $_POST['blog_title']);
                    if (!($blogModel->fetch(array('blog_key' => $blogKey)))) {
                        $uploadReturn = uploadSingleImg($_FILES['blog_image'], "blog");
                        if (isset($uploadReturn['imgData'])) {
                            if (!($blogModel->insert(['sch_token' => $schToken, 'blog_key' => $blogKey, 'blog_title' => $_POST['blog_title'], 'blog_img' => $uploadReturn['imgData']['name'], 'blog_short_desc' => $_POST['blog_short_desc'], 'blog_story' => $_POST['blog_story'], 'addby' => CURRENTUSER]))) {
                                $blogModel->errors[] = "Blog story posted successfully!";
                            } else {
                                $blogModel->errors[] = "Error posting the blog story, kindly try again!";
                            }
                        } else {
                            $blogModel->errors = $uploadReturn['errors'];
                        }
                    } else {
                        $blogModel->errors[] = "THis blog post already exists in our database!";
                    }
                } else {
                    $blogModel->errors[] = "Featured image/photo cannot be empty!";
                }
            }
            // echo errors
            echo implode("\n", $blogModel->errors);
        } else {
            $data = [];
            $this->view('Blog', $data, __FUNCTION__);
        }
    }

    public function read($storyKey = "")
    {
        $data = [];
        $appData = new App;
        $allBlogStories = $appData->sch_blog();
        if ($allBlogStories) {
            foreach ($allBlogStories as $key => $value) {
                if ($value->blog_key == $storyKey) {
                    $data['blogStory'] = $value;
                } else {
                    $data['relatedStories'][] = $value;
                }
            }
        }
        $this->view('Blog', $data, __FUNCTION__);
    }

    public function update()
    {
        $data = [];
        $this->view('Blog', $data, __FUNCTION__);
    }

    public function delete()
    {
        $blogModel = new BlogModel;
        $blogInfo = $blogModel->fetch(['blog_key' => $_POST['blog_key']]);
        if ($blogInfo) {
            if (!(delImg($blogInfo->blog_img, "blog"))) {
                if (!($blogModel->delete($_POST['blog_key'], "blog_key"))) {
                    echo "Blog record deleted successfully!";
                } else {
                    echo "Error deleting the blog record, kindly try again!";
                }
            } else {
                echo "Error deleting the blog record, kindly try again!";
            }
        } else {
            echo "Error deleting the blog record, kindly try again!";
        }
    }
}
