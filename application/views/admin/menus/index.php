<!-- Nestable CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/starter_kit/vendor/jquery.nestable.min.css'); ?>">
<style>
    :root {
        --mac-bg: #1c1c1e;
        --mac-card: #2c2c2e;
        --mac-card-header: rgba(44, 44, 46, 0.8);
        --mac-text: #ffffff;
        --mac-text-dim: #a1a1a6;
        --mac-border: #38383a;
        --mac-blue: #0A84FF;
        --mac-green: #30D158;
        --mac-red: #FF453A;
        --mac-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    body { background: var(--mac-bg) !important; color: var(--mac-text) !important; }
    .content-wrapper { background: var(--mac-bg) !important; }

    .dd { max-width: 100%; }
    .dd-list .dd-item > button { height: 32px; width: 33px; font-size: 18px; margin: 4px 0; color: #fff; }
    .dd-handle {
        height: 44px;
        padding: 10px 18px;
        background: var(--mac-card) !important;
        border: 1px solid var(--mac-border) !important;
        border-radius: 8px;
        font-weight: 600;
        color: var(--mac-text) !important;
        cursor: move;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    .dd-handle:hover { border-color: var(--mac-blue) !important; background: rgba(255,255,255,0.05) !important; }
    .dd-handle i { font-size: 16px; margin-right: 12px; width: 20px; text-align: center; color: var(--mac-blue); }
    
    .menu-actions { margin-left: auto; display: flex; align-items: center; gap: 5px; }
    .menu-status-pill { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 12px; }
    .status-active { background-color: var(--mac-green); box-shadow: 0 0 8px var(--mac-green); }
    .status-inactive { background-color: var(--mac-red); box-shadow: 0 0 8px var(--mac-red); }

    .btn-menu-action { 
        width: 32px; height: 32px; padding: 0; line-height: 32px; 
        border-radius: 6px; border: 1px solid var(--mac-border); background: rgba(255,255,255,0.05); 
        color: #fff; transition: all 0.2s;
    }
    .btn-menu-action:hover { background: rgba(255,255,255,0.1); border-color: var(--mac-blue); }

    .box { background: var(--mac-card) !important; border-radius: 12px; border: 1px solid var(--mac-border) !important; overflow: hidden; box-shadow: var(--mac-shadow); }
    .box-header { background: var(--mac-card-header) !important; border-bottom: 1px solid var(--mac-border) !important; backdrop-filter: blur(10px); }
    .box-title { color: #fff !important; font-weight: 700 !important; }

    .info-card { background: var(--mac-card); border-radius: 12px; padding: 20px; border: 1px solid var(--mac-border); box-shadow: var(--mac-shadow); }
    .info-card h4 { font-weight: 700; color: #fff; margin-bottom: 15px; }
    .info-card ul { padding-left: 20px; color: var(--mac-text-dim); font-size: 13px; }
    .info-card li { margin-bottom: 10px; }

    .icon-preview-box {
        width: 45px; height: 45px; line-height: 45px; text-align: center;
        background: #000; border: 1px solid var(--mac-border); border-radius: 8px;
        font-size: 20px; color: var(--mac-blue);
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
            <div class="box-footer" id="orderFooter" style="display:none; padding:15px; background: #000; border-top: 1px solid var(--mac-border);">
                <div class="pull-left text-orange" style="margin-top: 5px;">
                    <i class="fa fa-warning"></i> <strong>Configuration changed!</strong> Save to apply new order.
                </div>
                <button class="btn btn-flat pull-right" id="btnSaveOrder" style="background: var(--mac-green); color: #fff; border-radius: 8px; padding: 6px 20px; font-weight: 700;"><i class="fa fa-save"></i> Save Hierarchy Plan</button>
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
            <div class="modal-header shadow-sm" style="border:0; background: #000 !important; color: #ffffff !important;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity: 1;">&times;</button>
                <h4 class="modal-title" id="menuModalTitle" style="color:#fff; font-weight: 700;">Menu Configuration</h4>
            </div>
            <form id="formMenu">
                <input type="hidden" name="id" id="menuId">
                <div class="modal-body" style="padding: 25px; background: #000;">
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
                <div class="modal-footer border-0" style="background: #000 !important; padding: 20px;">
                    <button type="button" class="btn btn-flat" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--mac-border); border-radius: 8px; padding: 8px 20px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-flat" style="background: var(--mac-blue); color: #fff; border-radius: 8px; padding: 8px 25px; font-weight: 700;"><i class="fa fa-save"></i> Save Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Nestable JS -->
<script src="<?php echo base_url('assets/starter_kit/vendor/jquery.nestable.min.js'); ?>"></script>

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
