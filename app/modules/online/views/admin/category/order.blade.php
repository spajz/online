<div id="content-header" class="mini">
    <h1>{{ $moduleUpper }}</h1>
</div>
<div id="breadcrumb">
    <a href="{{ route('admin') }}" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a>
    <a href="#" class="current">{{ $moduleUpper }}</a>
</div>
<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fa fa-th"></i>
                </span>
                <h5>List</h5>
            </div>
            <div class="widget-content nopadding">
                <input type="button" value="ovde" id="ft">

                <div id="tree"></div>
            </div>
        </div>
    </div>
</div>
@section('scripts_bottom')
@parent
<script type="text/javascript">
    $(function () {
        // Create the tree inside the <div id="tree"> element.
        $("#tree").fancytree({
            source: {
                url: "{{ route("api.{$moduleAdminRoute}.gettree") }}"
            },
            extensions: ["dnd", "persist"],

            persist: {
                expandLazy: true,
                overrideSource: false, // true: cookie takes precedence over `source` data attributes.
                store: "auto" // 'cookie', 'local': use localStore, 'session': sessionStore
            },

            dnd: {
                autoExpandMS: 400,
                focusOnClick: true,
                preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
                preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
                dragStart: function (node, data) {
                    /** This function MUST be defined to enable dragging for the tree.
                     *  Return false to cancel dragging of node.
                     */
                    return true;
                },
                dragEnter: function (node, data) {
                    /** data.otherNode may be null for non-fancytree droppables.
                     *  Return false to disallow dropping on node. In this case
                     *  dragOver and dragLeave are not called.
                     *  Return 'over', 'before, or 'after' to force a hitMode.
                     *  Return ['before', 'after'] to restrict available hitModes.
                     *  Any other return value will calc the hitMode from the cursor position.
                     */
                    // Prevent dropping a parent below another parent (only sort
                    // nodes under the same parent)
                    /*           if(node.parent !== data.otherNode.parent){
                     return false;
                     }
                     // Don't allow dropping *over* a node (would create a child)
                     return ["before", "after"];
                     */
                    return true;
                },
                dragDrop: function (node, data) {
                    /** This function MUST be defined to enable dropping of items on
                     *  the tree.
                     */
                    data.otherNode.moveTo(node, data.hitMode);

                    sendTreeData();
                }
            },
            activate: function (event, data) {
                //        alert("activate " + data.node);
            }
        });

        function sendTreeData() {
            var tree = $("#tree").fancytree("getTree");
            var treeData = tree.toDict(true);
            //alert(JSON.stringify(d));

            $.ajax({
                url: baseUrlAdmin + "/api/{{ $moduleAdminRoute }}/tree",
                type: "post",
                data: treeData,
                success: function (data, textStatus, jqXHR) {
                    console.log(data);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Server error.')
                }
            });
        }
    });
</script>

@stop