$(function () {
    var token = $('meta[name=csrf-token]').attr('content');

    var grid = $("#grid-data").bootgrid({
        ajax: true,
        post: function() {
            return {
                '_token': token
            };
        },
        url: grid_url+'/grid',
        searchSettings: {
            delay: 100,
            characters: 2
        },
        formatters: {
            actions: function(column, row) {
                var field = (typeof row.slug != 'undefined') ? row.slug : row.id;
                var html = '<ul class="list-inline list-unstyled">';
                    if(grid_view_front) {
                        html += '<li><a href="'+grid_view_front_url+'/'+field+'" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></li>';
                    }
                    html += '<li><a href="'+grid_url+'/'+row.id+'/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a></li>' +
                    '<li><form method="POST" action="'+grid_url+'/'+row.id+'">' +
                    '<input name="_token" type="hidden" value="'+token+'">' +
                    '<input name="_method" type="hidden" value="DELETE">' +
                    '<button class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i></button>' +
                    '</form></li>' +
                    '</ul>';

                return html;
            },
            is_active: function(column, row) {
                if(row.is_active == 1) {
                    return '<span class="label label-success">Yes</span>';
                }else {
                    return '<span class="label label-danger">No</span>';
                }
            },
            is_approved: function(column, row) {
                if(row.is_approved == 1) {
                    return '<span class="label label-success">Yes</span>';
                }else {
                    return '<span class="label label-danger">No</span>';
                }
            },
            is_spam: function(column, row) {
                if(row.is_spam == 1) {
                    return '<span class="label label-success">Yes</span>';
                }else {
                    return '<span class="label label-danger">No</span>';
                }
            },
            is_premium: function(column, row) {
                if(row.is_premium == 1) {
                    return '<span class="label label-success">Yes</span>';
                }else {
                    return '<span class="label label-danger">No</span>';
                }
            },
            is_global: function(column, row) {
                if(row.is_global == 1) {
                    return '<span class="label label-success">Yes</span>';
                }else {
                    return '<span class="label label-danger">No</span>';
                }
            },
            role: function(column, row) {
                if(row.state == 0) {
                    return 'Administrator';
                }else if(row.state == 1) {
                    return 'Member';
                }else {
                    return 'Business';
                }
            },
            status: function(column, row) {
                if(row.state == 0) {
                    return '<span class="label label-danger">Inactive</span>';
                }else if(row.state == 1) {
                    return '<span class="label label-success">Active</span>';
                }else {
                    return '<span class="label label-warning">Banned</span>';
                }
            },
            user_editable: function(column, row) {
                if(row.user_editable == 1) {
                    return '<span class="label label-success">Yes</span>';
                }else {
                    return '<span class="label label-danger">No</span>';
                }
            }
        }
    }).on('loaded.rs.jquery.bootgrid', function() {
        grid.find('.delete').click(function(e) {
            e.preventDefault();
            var self = $(this);

            bootbox.confirm('Are you sure?', function (result) {
                if (result) {
                    var form = self.parent('form');

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize()
                    }).done(function(response){
                        $.bootstrapGrowl(response.msg, {type: response.msg_type});
                        if(response.msg_type == 'success') {
                            $('#grid-data').bootgrid('reload');
                        }
                    })
                }
            })
        });
    });
});