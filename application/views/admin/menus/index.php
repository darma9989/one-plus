<!-- Nestable CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
<style>
    .dd { max-width: 100%; }
    .dd-list .dd-item > button { height: 32px; width: 33px; font-size: 18px; margin: 4px 0; }
    .dd-handle {
        height: 44px;
        padding: 10px 18px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-weight: 600;
        color: #334155;
        cursor: move;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    .dd-handle:hover { border-color: #3b82f6; color: #3b82f6; background: #f8fafc; }
    .dd-handle i { font-size: 16px; margin-right: 12px; width: 20px; text-align: center; color: #64748b; }
    .dd-item:hover > .dd-handle i { color: #3b82f6; }
    
    .menu-actions { margin-left: auto; display: flex; align-items: center; gap: 5px; }
    .menu-status-pill { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 10px; }
    .status-active { background-color: #22c55e; box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1); }
    .status-inactive { background-color: #ef4444; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1); }

    .btn-menu-action { 
        width: 28px; height: 28px; padding: 0; line-height: 28px; 
        border-radius: 4px; border: 1px solid #e2e8f0; background: #fff; 
        color: #64748b; transition: all 0.2s;
    }
    .btn-menu-action:hover { background: #f1f5f9; color: #1e293b; border-color: #cbd5e1; }
    .btn-menu-edit:hover { color: #f59e0b; border-color: #f59e0b; background: #fffbeb; }
    .btn-menu-delete:hover { color: #ef4444; border-color: #ef4444; background: #fef2f2; }

    .info-card { background: #fff; border-radius: 8px; padding: 20px; border: 1px solid #e2e8f0; }
    .info-card h4 { font-weight: 700; color: #1e293b; margin-bottom: 15px; }
    .info-card ul { padding-left: 20px; color: #64748b; font-size: 13px; }
    .info-card li { margin-bottom: 10px; }

    .icon-preview-box {
        width: 45px; height: 45px; line-height: 45px; text-align: center;
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;
        font-size: 20px; color: #3b82f6;
    }
</style>

<div class="row">
    <div class="col-md-7">
        <div class="box box-primary border-0 shadow-sm">
            <div class="box-header with-border" style="padding: 15px 20px;">
                <h3 class="box-title" style="font-weight: 700;"><i class="fa fa-sitemap text-primary"></i> Navigation Hierarchy</h3>
                <div class="box-tools">
                    <div class="btn-group">
                        <button class="btn btn-default btn-sm btn-flat" id="btnExpandAll" title="Expand All"><i class="fa fa-plus-square"></i> Expand</button>
                        <button class="btn btn-default btn-sm btn-flat" id="btnCollapseAll" title="Collapse All"><i class="fa fa-minus-square"></i> Collapse</button>
                    </div>
                    <button class="btn btn-primary btn-sm btn-flat" onclick="showAddMenu()" style="margin-left: 5px;"><i class="fa fa-plus"></i> Add New Menu</button>
                </div>
            </div>
            <div class="box-body" style="padding: 20px;">
                <div class="dd" id="nestableMenu">
                    <ol class="dd-list">
                        <?php
                        function render_menu_nestable($menus) {
                            foreach ($menus as $m) {
                                $status_class = $m['menu_status'] ? 'status-active' : 'status-inactive';
                                echo '<li class="dd-item" data-id="'.$m['id'].'">';
                                echo '  <div class="dd-handle">';
                                echo '    <i class="'.$m['menu_icon'].'"></i> '.$m['menu_name'];
                                echo '  </div>';
                                echo '  <div class="menu-actions" style="position: absolute; right: 10px; top: 8px; z-index: 10;">';
                                echo '    <span class="menu-status-pill '.$status_class.'" title="'.($m['menu_status'] ? 'Active' : 'Disabled').'"></span>';
                                echo '    <button type="button" class="btn-menu-action btn-menu-edit" onclick="editMenu('.$m['id'].')" title="Edit"><i class="fa fa-pencil"></i></button>';
                                echo '    <button type="button" class="btn-menu-action btn-menu-delete" onclick="deleteMenu('.$m['id'].')" title="Delete"><i class="fa fa-trash"></i></button>';
                                echo '  </div>';
                                if (isset($m['children']) && !empty($m['children'])) {
                                    echo '<ol class="dd-list">';
                                    render_menu_nestable($m['children']);
                                    echo '</ol>';
                                }
                                echo '</li>';
                            }
                        }
                        if (isset($menus) && !empty($menus)) {
                            render_menu_nestable($menus);
                        } else {
                            echo '<div class="text-center p-20 text-muted">No menu items found. Click "Add New Menu" to start.</div>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
            <div class="box-footer bg-gray-light" id="orderFooter" style="display:none; padding:15px;">
                <div class="pull-left text-orange" style="margin-top: 5px;">
                    <i class="fa fa-warning"></i> <strong>Configuration changed!</strong> Save to apply new order.
                </div>
                <button class="btn btn-success btn-flat pull-right" id="btnSaveOrder"><i class="fa fa-save"></i> Save Hierarchy Plan</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="info-card shadow-sm">
            <h4><i class="fa fa-lightbulb-o text-yellow"></i> Pro Tips</h4>
            <ul>
                <li><strong>Drag & Drop:</strong> Grab the menu handle and move it up, down, or indent it to create a sub-menu.</li>
                <li><strong>Multi-Level:</strong> This system supports up to 2 levels of navigation (Parent & Child) to keep the sidebar clean.</li>
                <li><strong>Menu Links:</strong> For a parent menu that only serves as a folder, use <code>#</code> as the link.</li>
                <li><strong>Icons:</strong> We use FontAwesome 4.7. You can find reference at <a href="https://fontawesome.com/v4/icons/" target="_blank">fontawesome.com/v4/icons <i class="fa fa-external-link"></i></a></li>
            </ul>
        </div>
        
        <div class="well no-shadow border-0" style="background:#f8fafc; border: 1px dashed #cbd5e1; margin-top: 20px; padding: 25px;">
            <h5 style="font-weight: 700; color: #475569;">System Performance</h5>
            <p class="text-muted small">Menu changes are cached globally for performance. You may need to refresh the page to see changes in the sidebar.</p>
        </div>
    </div>
</div>

<!-- Modal Add/Edit Menu -->
<div class="modal fade" id="modalMenu">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
                <h4 class="modal-title" id="menuModalTitle" style="color:#fff; font-weight: 600;">Menu Configuration</h4>
            </div>
            <form id="formMenu">
                <input type="hidden" name="id" id="menuId">
                <div class="modal-body" style="padding: 25px;">
                    <div class="form-group">
                        <label>Display Label <span class="text-danger">*</span></label>
                        <input type="text" name="menu_name" id="menuName" class="form-control" placeholder="Dashboard, Users, etc." required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Menu Icon <small class="text-muted">(FA Class)</small></label>
                                <input type="text" name="menu_icon" id="menuIcon" class="form-control" placeholder="fa fa-circle-o">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Preview</label>
                            <div class="icon-preview-box">
                                <i id="iconPreview" class="fa fa-circle-o"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Endpoint URL / Link</label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo base_url(); ?></span>
                            <input type="text" name="menu_link" id="menuLink" class="form-control" placeholder="admin/dashboard">
                        </div>
                        <p class="help-block small">Use <code>#</code> if this menu has sub-menus.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Parent Position</label>
                                <select name="parent_id" id="menuParent" class="form-control">
                                    <option value="">— Primary (Top Level) —</option>
                                    <?php if (isset($parent_menus)): foreach ($parent_menus as $p): ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['menu_name']; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Visibility Status</label>
                                <select name="menu_status" id="menuStatus" class="form-control">
                                    <option value="1">Show in Sidebar</option>
                                    <option value="0">Hide / Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-gray-light">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Nestable JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>

<script>
var menuEditMode = false;

$(function(){
    $('#nestableMenu').nestable({
        group: 1,
        maxDepth: 2,
        callback: function(l, e) {
            $('#orderFooter').fadeIn();
        }
    });

    $('#btnExpandAll').click(function(){ $('.dd').nestable('expandAll'); });
    $('#btnCollapseAll').click(function(){ $('.dd').nestable('collapseAll'); });

    // Live icon preview
    $('#menuIcon').on('input', function(){
        $('#iconPreview').attr('class', $(this).val());
    });

    $('#btnSaveOrder').click(function(){
        var items = [];
        var serializeItems = function(list, pid) {
            $.each(list, function(i, item){
                items.push({
                    id: item.id,
                    parent_id: pid || null,
                    order: i
                });
                if(item.children) serializeItems(item.children, item.id);
            });
        };
        serializeItems($('#nestableMenu').nestable('serialize'), null);

        $.post(BASE_URL+'admin/menus/update_order', {items: items}, function(res){
            var r = JSON.parse(res);
            if(r.status=='success'){
                App.toast(r.message, 'success');
                $('#orderFooter').fadeOut();
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    });
});

function showAddMenu(){
    menuEditMode = false;
    $('#menuModalTitle').text('Register Primary Menu');
    $('#formMenu')[0].reset();
    $('#menuId').val('');
    $('#menuIcon').val('fa fa-circle-o');
    $('#iconPreview').attr('class', 'fa fa-circle-o');
    $('#modalMenu').modal('show');
}

function editMenu(id){
    menuEditMode = true;
    $.post(BASE_URL+'admin/menus/get_menu', {id:id}, function(res){
        var m = JSON.parse(res);
        $('#menuModalTitle').text('Configure: ' + m.menu_name);
        $('#menuId').val(m.id);
        $('#menuName').val(m.menu_name);
        $('#menuIcon').val(m.menu_icon);
        $('#iconPreview').attr('class', m.menu_icon);
        $('#menuLink').val(m.menu_link);
        $('#menuParent').val(m.parent_id || '');
        $('#menuStatus').val(m.menu_status);
        $('#modalMenu').modal('show');
    });
}

$('#formMenu').submit(function(e){
    e.preventDefault();
    var url = menuEditMode ? BASE_URL+'admin/menus/update' : BASE_URL+'admin/menus/add';
    $.post(url, $(this).serialize(), function(res){
        var r = JSON.parse(res);
        if(r.status=='success'){
            $('#modalMenu').modal('hide');
            App.toast(r.message, 'success');
            setTimeout(function(){ location.reload(); }, 1500);
        } else {
            App.alert('Error', r.message, 'error');
        }
    });
});

function deleteMenu(id){
    App.confirm('Delete Menu & References?', 'All sub-menus under this item will also be permanently detached.', function(){
        $.post(BASE_URL+'admin/menus/delete',{id:id},function(res){
            var r=JSON.parse(res);
            if(r.status=='success'){
                App.toast(r.message, 'success');
                setTimeout(function(){ location.reload(); }, 1500);
            } else {
                App.alert('Error', r.message, 'error');
            }
        });
    }, 'warning');
}
</script>
