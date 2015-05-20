jQuery(document).ready(function($) {
    function c5_get_closest_object(from, object) {
        var parent_obj = from.closest('.format-settings');
        return parent_obj.find(object);
    }

    C5AB_POSTS_SELECT_JS = {
        init: function() {
            var obj_test = c5_get_closest_object($('.format-setting-label'), '.format-setting');
            obj_test.addClass('test-test');

            $('.c5-author-search-ajax').selectize({
                valueField: 'value',
                labelField: 'title',
                searchField: ['title'],
                create: false,
                sortField: 'text',
                render: {
                    option: function(item, escape) {
                        return '<div class="option"><span class="title">' + escape(item.title) + '</span></div>';
                    }
                },
                load: function(query, callback) {
                    if (query != '') {
                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: {
                                name: query,
                                action: 'c5_search_authors_via_ajax'
                            },
                            error: function() {
                                callback();
                            },
                            success: function(res) {
                                callback(jQuery.parseJSON(res));
                            }
                        });
                    }
                }
            });
            $('.c5-post-type').each(function handle_post_type() {
                var this_obj = $(this);

                this_obj.selectize({
                    valueField: 'value',
                    labelField: 'title',
                    searchField: ['title'],
                    create: false,
                    sortField: 'text',
                    render: {
                        option: function(item, escape) {
                            return '<div class="option"><span class="title">' + escape(item.title) + '</span></div>';
                        }
                    },
                    onChange: function(value) {
                        c5_create_taxonomies_dropdown(value, this_obj);
                    },
                    load: function(query, callback) {
                        if ($('select.c5-post-type').hasClass('c5-screen-widgets')) {
                            $.ajax({
                                url: ajaxurl,
                                type: 'post',
                                data: {
                                    q: query,
                                    action: 'c5_get_ajax_post_types'
                                },
                                error: function() {
                                    callback();
                                },
                                success: function(res) {
                                    callback(jQuery.parseJSON(res));
                                }
                            });
                        }
                    }
                });
            });
            $('.c5-posts-search-post-type').each(function handle_post_search() {
                var this_obj = $(this);
                this_obj.selectize({
                    valueField: 'value',
                    labelField: 'title',
                    searchField: ['title'],
                    create: false,
                    sortField: 'text',
                    render: {
                        option: function(item, escape) {
                            return '<div class="option"><span class="title">' + escape(item.title) + '</span></div>';
                        }
                    },
                    onChange: function(value) {
                        if (value != '') {
                            $.ajax({
                                type: "post",
                                url: ajaxurl,
                                data: "action=c5_get_posts_by_search&post_type=" + value,
                                success: function(data) {
                                	var main_append_obj = c5_get_closest_object(this_obj, '.c5-articles-wrap');
                                    main_append_obj.html(data);
                                    main_append_obj.find('select').selectize({
                                        valueField: 'value',
                                        labelField: 'title',
                                        searchField: ['title'],
                                        //options: [],
                                        create: false,
                                        render: {
                                            option: function(item, escape) {
                                                return '<div class="option"><span class="title">' + escape(item.title) + '</span></div>';
                                            }
                                        },
                                        onChange: function(final_value) {
                                            if (final_value != '') {
                                                $.ajax({
                                                    type: "post",
                                                    url: ajaxurl,
                                                    data: "action=c5_get_article_name_ajax&value=" + final_value,
                                                    success: function(data) {
                                                        var append_obj = c5_get_closest_object(main_append_obj, 'ul.c5-posts-current-values');
                                                        append_obj.append('<li class="ui-state-default" data-info="' + final_value + '">' + data + '<span class="fa fa-times"></span></li>');


                                                        var save_obj = c5_get_closest_object(main_append_obj, '.c5-save-posts-search-value');
                                                        var new_value = c5_add_value_to_string(final_value, save_obj.val());
                                                        save_obj.val(new_value);
                                                        c5_enable_sortable_post_types();
                                                    }
                                                });
                                            }

                                        },
                                        load: function(query, callback) {
                                            if (!query.length)
                                                return callback();
                                            $.ajax({
                                                url: ajaxurl,
                                                type: 'post',
                                                data: {
                                                    post_type: value,
                                                    q: query,
                                                    action: 'c5_search_for_articles'
                                                },
                                                error: function() {
                                                    callback();
                                                },
                                                success: function(res) {
                                                    callback(jQuery.parseJSON(res));
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    },
                    load: function(query, callback) {
                        if ($('select.c5-posts-search-post-type').hasClass('c5-screen-widgets')) {
                            $.ajax({
                                url: ajaxurl,
                                type: 'post',
                                data: {
                                    q: query,
                                    action: 'c5_get_ajax_post_types'
                                },
                                error: function() {
                                    callback();
                                },
                                success: function(res) {
                                    callback(jQuery.parseJSON(res));
                                }
                            });
                        }
                    }
                });
            });
            c5_enable_sortable_posts();
            c5_enable_sortable_post_types();
            c5_enable_sortable_meta_data();
        }
    }
    C5AB_POSTS_SELECT_JS.init();
    function c5_create_taxonomies_terms_dropdown(second_value, parent_obj) {
        if (second_value != '') {
            $.ajax({
                type: "post",
                url: ajaxurl,
                data: "action=c5_get_tax_ajax_terms&value=" + second_value,
                success: function(data) {
                    var main_append_obj = c5_get_closest_object(parent_obj, '.c5-terms-wrap');

                    main_append_obj.html(data);
                    if ($('.c5-terms-wrap select').hasClass('c5-searchable')) {
                        main_append_obj.find('select').selectize({
                            valueField: 'value',
                            labelField: 'title',
                            searchField: ['title'],
                            //options: [],
                            create: false,
                            render: {
                                option: function(item, escape) {
                                    return '<div class="option"><span class="title">' + escape(item.title) + '</span></div>';
                                }
                            },
                            onChange: function(final_value) {
                                if (final_value != '') {
                                    $.ajax({
                                        type: "post",
                                        url: ajaxurl,
                                        data: "action=c5_get_tax_ajax_name&value=" + final_value,
                                        success: function(data) {
                                            var append_obj = c5_get_closest_object(parent_obj, 'ul.c5-current-values');
                                            append_obj.append('<li class="ui-state-default" data-info="' + final_value + '">' + data + '<span class="fa fa-times"></span></li>');


                                            var save_obj = c5_get_closest_object(parent_obj, '.c5-save-post-type-value');
                                            var new_value = c5_add_value_to_string(final_value, save_obj.val());
                                            save_obj.val(new_value);
                                            c5_enable_sortable_post_types();
                                        }
                                    });
                                }

                            },
                            load: function(query, callback) {
                                if (!query.length)
                                    return callback();
                                $.ajax({
                                    url: ajaxurl,
                                    type: 'post',
                                    data: {
                                        value: second_value,
                                        q: query,
                                        action: 'c5_search_terms_ajax'
                                    },
                                    error: function() {
                                        callback();
                                    },
                                    success: function(res) {
                                        callback(jQuery.parseJSON(res));
                                    }
                                });
                            }
                        });

                    } else {
                        main_append_obj.find('select').selectize({
                            create: false,
                            sortField: 'text',
                            onChange: function(final_value) {
                                if (final_value != '') {
                                    $.ajax({
                                        type: "post",
                                        url: ajaxurl,
                                        data: "action=c5_get_tax_ajax_name&value=" + final_value,
                                        success: function(data) {
                                            var append_obj = c5_get_closest_object(parent_obj, 'ul.c5-current-values');
                                            append_obj.append('<li class="ui-state-default" data-info="' + final_value + '">' + data + '<span class="fa fa-times"></span></li>');


                                            var save_obj = c5_get_closest_object(parent_obj, '.c5-save-post-type-value');
                                            var new_value = c5_add_value_to_string(final_value, save_obj.val());
                                            save_obj.val(new_value);
                                            c5_enable_sortable_post_types();
                                        }
                                    });
                                }

                            }
                        });
                    }

                }
            });
        }

    }

    function c5_create_taxonomies_dropdown(value, parent_obj) {
        if (value != '') {
            $.ajax({
                type: "post",
                url: ajaxurl,
                data: "action=c5_get_post_type_terms&post_type=" + value,
                success: function(data) {


                    var append_obj = c5_get_closest_object(parent_obj, '.c5-categories-wrap');

                    append_obj.html(data);
                    append_obj.find('select').selectize({
                        create: false,
                        sortField: 'text',
                        onChange: function(second_value) {
                            c5_create_taxonomies_terms_dropdown(second_value, parent_obj);
                        }
                    });
                }
            });
        }

    }




    $(document).on('click', 'ul.c5-current-values li .fa-times', function(e) {
        var this_obj = $(this);
        var data_to_remove = this_obj.parent().attr('data-info');
        var save_object = c5_get_closest_object( this_obj , '.c5-save-post-type-value');
        
        this_obj.parent().remove();

        var hidden_value = save_object.val();
        
        var final_value = c5_remove_value_from_string(data_to_remove, hidden_value);
        save_object.val(final_value);

    });
    $(document).on('click', 'ul.c5-posts-current-values li .fa-times', function(e) {
         var this_obj = $(this);
        var data_to_remove = this_obj.parent().attr('data-info');
        var save_object = c5_get_closest_object( this_obj , '.c5-save-posts-search-value');
        
        this_obj.parent().remove();

        
        var hidden_value = save_object.val();

        var final_value = c5_remove_value_from_string(data_to_remove, hidden_value);

        save_object.val(final_value);

    });



    function c5_remove_value_from_string(data_to_remove, orignial_value) {

        var myarr = orignial_value.split(",");
        var counter = 0;
        var final_value = '';
        $.each(myarr, function(key, value) {
            if (value != data_to_remove) {
                if (counter == 0) {
                    final_value = value;
                } else {
                    final_value = final_value + ',' + value;
                }
                counter++;
            }
        });
        return final_value;
    }
    function c5_add_value_to_string(data_to_add, orignial_value) {
        if (orignial_value == '') {
            orignial_value = data_to_add;
        } else {
            orignial_value = orignial_value + ',' + data_to_add;
        }
        return orignial_value;
    }
    function c5_enable_sortable_posts() {
        $('ul.c5-posts-current-values').sortable({
            placeholder: "c5-article-placeholder",
            items: ".ui-state-default",
            stop: function(event, ui) {
                c5_update_posts_search_value(ui.item);
            }
        });
    }
    function c5_enable_sortable_post_types() {
        $('ul.c5-current-values').sortable({
            placeholder: "c5-article-placeholder",
            items: ".ui-state-default",
            stop: function(event, ui) {
                c5_update_post_type_search_value(ui.item);
            }
        });
    }

    function c5_update_post_type_search_value(sender) {
        var final_value = '';
        var counter = 0;
		alert(sender);
        var ul_values = c5_get_closest_object(sender, 'ul.c5-current-values li');

        ul_values.each(function(e) {
            var value = $(this).attr('data-info');
            if (counter == 0) {
                final_value = value;
            } else {
                final_value = final_value + ',' + value;
            }
            counter++;
        });
        var save_obj = c5_get_closest_object(sender, '.c5-save-post-type-value');
        save_obj.val(final_value);
    }

    function c5_update_posts_search_value(sender) {
        var final_value = '';
        var counter = 0;

        var ul_values = c5_get_closest_object(sender, 'ul.c5-posts-current-values li');

        ul_values.each(function(e) {
            var value = $(this).attr('data-info');
            if (counter == 0) {
                final_value = value;
            } else {
                final_value = final_value + ',' + value;
            }
            counter++;
        });
        var save_obj = c5_get_closest_object(sender, '.c5-save-posts-search-value');
        save_obj.val(final_value);
    }
    
    function c5_enable_sortable_meta_data() {
    
    	$('ul.c5-meta-data-values').each(function () {
    	    var this_obj = $(this);
    	    var parent_obj = this_obj.closest('.format-setting-inner');
    	    this_obj.sortable({
	            placeholder: "c5-article-placeholder",
	            items: ".ui-state-default",
	            stop: function(event, ui) {
	            	c5_update_meta_data_value(parent_obj);
	            }
	        });
	    });
    }
    
    function c5_update_meta_data_value(parent_obj) {
    	var final_value = '';
    	var counter = 0;
    	parent_obj.find('li').each(function(e) {
    	    var value = $(this).attr('data-info') + '_' +  $(this).attr('data-status');
    	    if (counter == 0) {
    	        final_value = value;
    	    } else {
    	        final_value = final_value + ',' + value;
    	    }
    	    counter++;
    	});
    	
//    	var save_obj = c5_get_closest_object(parent_obj, '.c5-save-meta-data-value');
    	
    	parent_obj.find('.c5-save-meta-data-value').val(final_value);	
    }
    
    $(document).on('click', 'ul.c5-meta-data-values li .fa.c5-change-status', function(e) {
            var current_status = $(this).parent().attr('data-status');
            if(current_status == 'on'){
            	$(this).parent().attr('data-status','off');
            	$(this).removeClass('fa-eye').addClass('fa-eye-slash');
            	$(this).parent().removeClass('c5-current-status-on').addClass('c5-current-status-off');
            }else {
            	$(this).parent().attr('data-status','on');
            	$(this).removeClass('fa-eye-slash').addClass('fa-eye');
            	$(this).parent().removeClass('c5-current-status-off').addClass('c5-current-status-on');
            }
            c5_update_meta_data_value( $(this).closest('.format-setting-inner')) ;
    
        });





});