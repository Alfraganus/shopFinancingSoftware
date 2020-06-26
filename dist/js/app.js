function fmsc_init() {
    $(document).ready(function(e) {
        var windowHeight = $(window).height();
        var mediaBrowserDirs = $('#dirs-result-c');
        var mediaBrowserFrame = $('#fm-right-b-scroll');

        $('body').tooltip({
            selector: "[data-tooltip=tooltip]",
            container: "body"
        });

        var popupwindow = $("#iframe-ms .load-xframe");

        if (popupwindow.length > 0)
        {
            windowHeight = popupwindow.height();

            $('#left-dir, #fm-right-cont').height(windowHeight - 40);
            mediaBrowserDirs.height(windowHeight - 95);

            $('#fm-right-cont > .fm-right-cont-c').height(windowHeight - 80);
            mediaBrowserFrame.height(windowHeight - 135);
        }

    });
}

$(document).ready(function() {

    // LEFT FOLDERS CLICK FUNCTION
    $(document).on('click', '#dirs-nav .dir-n-item', function() {
        var $this = $(this);
        var foldername = $this.data('open-folder');
        var title = $(this).children('span.dirs-item-title').html();

        $('#dirs-nav li .dir-n-item').removeClass('active');
        $this.toggleClass('active');

        $('#dirs-nav li .dir-n-item').each(function() {
            $this.attr('data-folder-selected', 0);
        });

        if($this.hasClass('active')) {
            $this.attr('data-folder-selected', 1);
            $('#thisfolder').val(foldername);
            var element = $this;

            parseFolderName(foldername);
            loadSubFolders(foldername, element);
        }
    });

    // FOLDERS OPEN
    $(document).on('click', '[data-open-folder]', function() {
        var $this = $(this);
        var folder = $this.data('open-folder');

        loadFiles(folder);
    });

    // LEFT FOLDERS TOGGLE ICON FUNCTION
    $(document).on('click', '.folder-toggle-icon', function() {
        var $this = $(this);
        var $submenu = $this.parent().children('ul.subdir');

        if($submenu.children().length > 0) {
            if($submenu.css('display') == 'none') {
                $this.removeClass('fa-caret-right')
                    .addClass('fa-caret-down');
                $submenu.slideDown(200);
            } else {
                $this.removeClass('fa-caret-down')
                    .addClass('fa-caret-right');
                $submenu.slideUp(100);
            }
        }
        else {
            $this.parent().children('.dir-n-item').trigger('click');
        }
    });


    // REFRESH DIRS AND FILES BUTTON
    $(document).on('click', '.f-refresh', function() {
        var folder = $('#thisfolder').val();
        parseFolderName(folder);

        loadFolders('/', folder);
        loadFiles('/', folder);
    });


    // CHANGE VIEW TYPE (LIST / GRID)
    $(document).on('click', 'ul.files-viewtype li', function() {
        var val = $(this).data('view-type');
        $('#viewtype').val(val);

        if($(this).hasClass('active')) {
            return true;
        }
        else {
            var folder = $('#thisfolder').val();
            loadFiles(folder);
        }

        $('ul.files-viewtype li').removeClass('active');
        $(this).toggleClass('active');

    });


    // ITEMS MULTISELECT FUNCTION
    $(document).on('click', '.fm-multiselect .fm-file-select', function() {
        $(this).attr('data-file-selected', 0);
        $(this).toggleClass('active');

        if($(this).hasClass('active')) {
            $(this).attr('data-file-selected', 1);
        }
    });

    $(document).on('click', '.fm-multiselect .fm-grid-info-title', function() {
        var $parent = $(this).closest('.fm-file-info-grid');
        $parent.attr('data-file-selected', 0);
        $parent.toggleClass('active');

        if($parent.hasClass('active')) {
            $parent.attr('data-file-selected', 1);
        }
    });


    // ITEMS MULTISELECT FUNCTION
    $(document).on('click', '.fm-singleselect .fm-file-select', function() {
        $('[data-file-selected]').attr('data-file-selected', 0)
            .removeClass('active');
        $(this).toggleClass('active');

        if($(this).hasClass('active')) {
            $(this).attr('data-file-selected', 1);
        }
    });

    $(document).on('click', '.fm-singleselect .fm-grid-info-title', function() {
        var $parent = $(this).closest('.fm-file-info-grid');

        $('[data-file-selected]').attr('data-file-selected', 0)
            .removeClass('active');
        $parent.toggleClass('active');

        if($parent.hasClass('active')) {
            $parent.attr('data-file-selected', 1);
        }
    });

    $(document).on('mouseenter mouseleave', '.fm-grid-info-title', function(e) {
        var $icon = $(this).closest('.fm-file-info-grid').find('.fm-file-info-check');

        if (e.type == 'mouseenter') {
            $icon.addClass('showit');
        }
        else {
            $icon.removeClass('showit');
        }
    });


    // ITEMS SINGLE SELECT FUNCTION
    $(document).on('click', '.singleselect .fm-file-info, .singleselect .fm-file-info-grid', function() {
        $('.singleselect .file-info, .singleselect .fm-file-info-grid').attr('data-file-selected', 0)
            .removeClass('active');

        $(this).addClass('active');
        $(this).attr('data-file-selected', 1);
    });


    // CREATE DIRECTORY MODAL HIDE
    $('#createdir_modal').on('show.bs.modal', function (e) {
        var folder = $('#thisfolder').val();
        var $parentDirName = $(this).find('input.parent_dir_name');

        if(folder.length == 0) {
            folder = '/';
        }

        $parentDirName.val(folder);
    });


    // CREATE FILE FORM SUBMIT
    $(document).on('submit', '#xcreate-dir', function() {
        var folder = $('#thisfolder').val();

        $.ajax({
            url: thisurl,
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                preloader('show');
            },
            success: function(data) {
                setTimeout(function() {
                    preloader('hide');

                    $('#createdir_modal').modal('hide');
                    $('#xcreate-dir input[name="dirname"]').val('');
                    loadFolders('/', folder);
                }, 1500);
            },
            error: function() {
                setTimeout(function() {
                    preloader('hide');

                    $('#createdir_modal').modal('hide');
                    loadFolders('/', folder);
                }, 1500);
            }
        });

        return false;
    });


    // UPLOAD FILE
    $(document).on('submit', '.fileupload-form', function(e) {

        e.preventDefault();
        var folder = $('#thisfolder').val();

        var formData = new FormData($(this)[0]);
        formData.append('folder', folder);

        var $progressbar = $(this).find('.file-upload-progress');
        var $progressbarSpan = $(this).find('.file-upload-progress > span');
        var $progressbarPercent = $(this).find('.file-upload-progress > b');

        var $msgBlock = $(this).find('.file-upload-msg');
        var $errorBlock = $(this).find('.file-upload-msg-error');

        $progressbar.fadeIn(200);

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $progressbarSpan.width(percentComplete + '%');
                        $progressbarPercent.html(percentComplete + '%');
                    }
                }, false);

                return xhr;
            },
            url: thisurl,
            type : 'POST',
            data : formData,
            dataType: "json",
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            beforeSend: function() {
                $msgBlock.empty();
                $errorBlock.empty();
            },
            success: function(data) {
                $progressbar.hide();

                if(data.error) {
                    clearUploadModal(false);

                    $msgBlock.empty();
                    $errorBlock.html(data.error);
                }
                if(data.success) {
                    clearUploadModal(false);

                    $msgBlock.html(data.success);
                    loadFolders('/', folder);
                    loadFiles('/', folder);
                }
            }
        });


    });


    // HIDE UPLOAD FILE MODAL
    $('#uploadfiles_modal').on('hide.bs.modal', function (e) {
        clearUploadModal(true);
    });


    // UPLOAD INPUT ON CHANGE
    $(document).on('change', "#filesupload", function() {
        var $form = $(this).closest('.fileupload-form');
        var $progressbar = $form.find('.file-upload-progress');
        var $msgBlock = $form.find('.file-upload-msg');
        var $errorBlock = $form.find('.file-upload-msg-error');

        $progressbar.hide();
        $msgBlock.empty();
        $errorBlock.empty();

        readSelectedFiles();
    });


    // DELETE SELECTED FILES
    $(document).on('submit', '#xdelete-files', function(e) {
        e.preventDefault();

        var folder = $('#thisfolder').val();
        var $selectedItems = $('#fm-right-cont [data-file-selected=1]');

        if($selectedItems.length > 0) {
            var items = [];

            $selectedItems.each(function() {
                var file = $(this).data('file-url');
                items.push(file);
            });

            $.ajax({
                url: thisurl,
                type: 'POST',
                data: {csrftoken, type: 'actions', action: 'delete', files: items},
                dataType: 'json',
                beforeSend: function() {
                    preloader('show');
                },
                success: function(data) {
                    setTimeout(function() {
                        preloader('hide');

                        $('#delete_files').modal('hide');
                        loadFolders('/', folder);
                        loadFiles('/', folder);
                    }, 1500);
                },
                error: function() {
                    setTimeout(function() {
                        preloader('hide');

                        $('#delete_files').modal('hide');
                    }, 1500);
                }
            });
        }
        else {
            $('#delete_files').modal('hide');
        }
    });


    // FM ACTION
    $(document).on('click', '.fm-action', function() {
        var $selectedItems = $('#fm-right-cont [data-file-selected=1]');
        var action = $(this).data('fm-action');
        var files = [];

        if($selectedItems.length > 0) {
            if (action == 'delete') {
                $('#delete_files').modal('show');
                return false;
            }
            else {
                $selectedItems.each(function() {
                    var file = $(this).data('file');
                    files.push(file);
                });
            }
        }
    });


    var element;
    var useGallery;
    var galleryElement;

    $(document).on('click', '.iframe-ms-close', function() {
        $('#iframe-ms').fadeOut(250);
        $("#load-xframe").attr('src', '');

        element = null;
        useGallery = false;
        galleryElement = null;
    });

    $(document).on('click', '[data-fm-single]', function() {
        var input = $(this).data('fm-single');
        var path = $(this).data('fm-path');

        element = input;
        mediaManager(path, 'singleselect');
    });

    $(document).on('click', '[data-fm-gallery]', function() {
        var input = $(this).data('fm-gallery');
        var path = $(this).data('fm-path');

        useGallery = 1;
        galleryElement = input;
        mediaManager(path, 'multiselect');
    });

    $(document).on('click', '#put-fm-val', function() {
        var $preview = $('#img-preview-' + element);
        var iframe = $("#load-xframe").contents().find("body");
        var elements = iframe.find('[data-file-selected="1"]');
        var array = [];

        $(elements).each(function() {
            var filepath = $(this).data('file-url');

            array.push(filepath);
        });

        if(array.length > 0 && element !== null) {
            $('#' + element).val(array);

            if($preview.length > 0) {
                $preview.html('<a href="'+array+'" data-fancybox><img src="'+ array+'" alt="Image" /></a>');
            }
        }

        if(useGallery == 1 && array.length > 0) {
            var block_icons = '<div class="x-gal-icons"><i class="fa fa-times x-gal-delete"></i></div>';

            $.each( array, function( i, value ) {
                var block_img = '<img src="'+ value+'" alt="'+value+'" />';
                var block_input = '<input type="hidden" value="'+ value+'" name="'+galleryElement+'[]">';

                $('#' + galleryElement + ' > .x-gallery-area-in').append('<div class="x-gal-img">'+block_input+block_icons+'<a href="'+ value+'" data-fancybox="group">'+block_img+'</a></div>');
                $('#' + galleryElement).fadeIn();
            });
        }

        $('.iframe-ms-close').trigger('click');
    });

    $(document).on('click', '[data-clear-in]', function() {
        var input = $(this).attr('data-clear-in');
        var $preview = $('#img-preview-' + input);

        if($preview.length > 0) {
            $preview.empty();
        }

        $('#' + input).val('');
    });

    $('.input-file-image > input').on('change', function() {
        var id = $(this).attr('id');
        var val = $(this).val();
        var $preview = $('#img-preview-' + id);

        if (val != undefined && val.length > 0) {
            if($preview.length > 0) {
                $preview.html('<a href="'+val+'" data-fancybox><img src="'+ val+'" alt="Image" /></a>');
            }
        }
        else {
            $preview.empty();
        }
    });

});


// LOAD FILES
function loadFiles(folder, refresh)
{
    var viewtype = $('#viewtype').val();

    $.ajax({
        url: thisurl,
        type: 'POST',
        data: {csrftoken, folder, viewtype, type: 'load', action: 'files', refresh: refresh},
        beforeSend() {
            $('#fm-right-cont .folder-loader').fadeIn(200);
            $('#fm-right-cont .folder-results').hide();
        },
        success: function(data) {
            if(data) {
                $('#fm-right-cont .folder-results').html(data);
            }

            $('#fm-right-cont .folder-results').fadeIn(200);
            $('#fm-right-cont .folder-loader').hide();
        },
        error: function() {
            $('#fm-right-cont .folder-results').fadeIn(200);
            $('#fm-right-cont .folder-loader').hide();
        }
    });
}


// LOAD FOLDERS
function loadFolders(folder, refresh)
{
    $.ajax({
        url: thisurl,
        type: 'POST',
        data: {csrftoken, folder, type: 'load', action: 'folders', refresh: refresh},
        beforeSend() {
            $('.dirs-loader').fadeIn(200);
            $('.dirs-result').hide();
        },
        success: function(data) {
            if(data) {
                $('.dirs-result').html(data);
            }

            $('.dirs-result').fadeIn(200);
            $('.dirs-loader').hide();
        },
        error: function() {
            $('.dirs-result').fadeIn(200);
            $('.dirs-loader').hide();
        }
    });
}


// LOAD SUB FOLDERS
function loadSubFolders(folder, element, refresh)
{
    var icon = element.parent().children('.folder-toggle-icon');
    $.ajax({
        url: thisurl,
        type: 'POST',
        data: {csrftoken, folder, type: 'load', action: 'subfolders', refresh: refresh},
        beforeSend() {
            icon.removeClass('fa-caret-right fa-caret-down')
                .addClass('fa-refresh fa-spin');
        },
        success: function(data) {
            if(data) {
                element.parent().addClass('ul-opened');
                element.parent().children('ul.subdir').html(data).slideDown(300);
            }
            icon.removeClass('fa-refresh fa-caret-down fa-spin')
                .addClass('fa-caret-down');
        },
        error: function() {
            icon.removeClass('fa-refresh fa-caret-down fa-spin')
                .addClass('fa-caret-right');
        }
    });
}


// READ SELECTED FILES
function readSelectedFiles()
{
    var fi = document.getElementById('filesupload');

    if (fi.files.length > 0) {
        document.getElementById('input-files-list').innerHTML = 'Total Files: <b>' + fi.files.length + '</b>';
    }
}


// CLEAR UPLOAD MODAL FORM
function clearUploadModal(progressbar)
{
    $('input#filesupload').val('');
    $('#input-files-list').empty();
    $('.file-upload-msg').empty();
    $('.file-upload-msg-error').empty();

    if(progressbar) {
        $('.file-upload-progress').hide();
    }
}


// OPEN FILE MANAGER
function mediaManager(path, type)
{
    select_type = 'single';

    if (type == 'multiselect') {
        select_type = type;
    }

    $("#load-xframe").attr('src', '');
    $("#load-xframe").attr("src", dashurl + "media/window/" + select_type + '/' + path);
    $("#iframe-ms").fadeIn();
}


function parseFolderName(folder)
{
    var title = $('.rtop-left-title').data('real-name');
    var foldername = $('#thisfolder').val();

    if(folder == null) {
        folder = foldername;
    }

    if(folder == '/') {
        $('.rtop-left-title').html(title);
        return false;
    }

    var array = folder.split('/');
    var name = '';

    $.each(array, function(i, value) {
        name += ucfirst(value) + ' / ';
    });

    $('.rtop-left-title').html(name.slice(0,-2));
}