<?php

switch ($fileView) {
    case "create":
        if (in_array(VIEWFOLDER, array_keys(PORTALS))) {
?>

            <form enctype="multipart/form-data" class="addBlogForm">
                <div class="card border-0 shadow-sm">
                    <div class="card-header text-uppercase">create new blog story</div>
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="blog_title">News Title</label>
                            <textarea name="blog_title" id="blog_title" placeholder="News Title" class="form-control" rows="1"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="blog_image">Featured Image</label>
                            <input type="file" name="blog_image" id="blog_image" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="blog_short_desc">News Short Description</label>
                            <textarea name="blog_short_desc" id="blog_short_desc" placeholder="News Short Description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="blog_story">News Full Story</label>
                            <textarea name="blog_story" id="editor" placeholder="News Full Story" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="card-footer border-0 bg-transparent mb-2">
                        <button type="reset" class="btn btn-outline-danger float-start"><i class="fas fa-history"></i> Reset</button>
                        <button class="btn btn-outline-custom float-end"><i class="fas fa-save"></i> Post Story</button>
                    </div>
                </div>
            </form>

        <?php } else { ?>

            <script>
                window.location.href = "<?= ROOT ?>blog";
            </script>

        <?php
        }
        break;
    case "read":
        ?>

        <div class="container py-4">
            <div class="row">
                <div class="col-md-9">
                    <h5><?= ucfirst($data['blogStory']->blog_title) ?></h5>
                    <hr class="dividerDiv1">
                    <p><?= $data['blogStory']->blog_story ?></p>
                </div>
                <div class="col-md-3">
                    <h5>Related stories</h5>
                    <hr class="dividerDiv1">
                    <ul class="list-group relatedNews">
                        <?php if (isset($data['relatedStories'])) : foreach ($data['relatedStories'] as $key => $value) { ?>
                                <li class="list-group-item p-0 border-0 rounded-0 my-1">
                                    <table class="table table-borderless table-sm m-0 align-middle">
                                        <tr>
                                            <td class="pw-20 p-0"><img src="<?= imageCheck("blog", $value->blog_img, "default.png") ?>" alt="Post image" class="w-100 rounded"></td>
                                            <td class="p-1"></td>
                                            <td class="text-start">
                                                <a href="<?= ROOT . "blog/read/" . $value->blog_key ?>" class="text-dark d-block" target="_blank">
                                                    <b class="text-capitalize"><?= $value->blog_title ?></b><br>
                                                    <i><small>Date: <?= date("d/m/Y", strtotime($value->date)) ?></small></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                        <?php }
                        endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <?php
        break;
    case "update":
        break;
    default:
        if (!(in_array(VIEWFOLDER, array_keys(PORTALS)))) :
        ?>

            <div class="col-12 bg-img">
                <div class="container py-3 text-white text-capitalize">
                    <h3>Information Center</h3>
                    <h6>Latest school News and Updates</h6>
                </div>
            </div>
            <div class="container py-4">
                <div class="row">
                    <div class="col-md-9 h-100">

                    <?php endif; ?>

                    <div class="form-group mb-3">
                        <div class="input-group border-custom rounded">
                            <span class="input-group-text border-0 bg-transparent text-muted" id="basic-addon1"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control border-0 bg-transparent" placeholder="Search from our news room..." oninput="searchNewsRoom(this)" autofocus />
                        </div>
                    </div>

                    <ul class="list-group rounded">
                        <?php if (isset($data['blogStories'])) {
                            foreach ($data['blogStories'] as $key => $value) {
                        ?>

                                <li class="list-group-item rounded border-0 shadow-sm my-1 p-1">
                                    <table class="table table-borderless table-sm m-0 align-middle">
                                        <tr>
                                            <td class="pw-15 p-0"><img src="<?= imageCheck("blog", $value->blog_img, "default.png") ?>" alt="Post image" class="w-100 rounded"></td>
                                            <td class="text-start px-3">
                                                <a href="<?= ROOT . "blog/read/" . $value->blog_key ?>" class="text-dark d-block" target="_blank">
                                                    <h5 class="card-title text-uppercase"><u><b><?= $value->blog_title ?></b></u></h5>
                                                    <p class="card-text mb-0"><?= ucfirst(limitChar($value->blog_short_desc, 100)) ?></p>
                                                    <p class="card-text mb-0"><small class="text-muted">Last updated <?= date("d/m/Y", strtotime($value->date)) ?></small></p>
                                                </a>
                                            </td>
                                            <?php if (in_array(VIEWFOLDER, array_keys(PORTALS))) : ?>
                                                <td class="pw-5 text-nowrap">
                                                    <a href="<?= ROOT . VIEWFOLDER . "/blog/update/" . $value->blog_key ?>" class="btn btn-sm btn-outline-custom text-nowrap my-1"><i class="fas fa-edit"></i></a>
                                                    <a href="javascript.void:(0)" class="btn btn-sm btn-outline-danger text-nowrap my-1" onclick="deleteBlog('<?= $value->blog_key ?>')"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    </table>
                                </li>

                            <?php
                            }
                        } else {
                            ?>

                            <li class="list-group-item rounded border-0 py-5 text-center ">
                                <h4>Sorry, but there is no news found matching your search request!</h4>
                            </li>

                        <?php } ?>
                    </ul>

                    <?php if (!(in_array(VIEWFOLDER, array_keys(PORTALS)))) : ?>

                    </div>
                    <div class="col-md-3">
                        <h5>Our social media platforms</h5>
                        <hr class="dividerDiv1">
                    </div>
                </div>
            </div>

        <?php endif; ?>

<?php
        break;
}
