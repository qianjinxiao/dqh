
<div id="container{{$id}}" style="height:500px;"></div>
<script type="text/javascript">
    window._AMapSecurityConfig = {
        securityJsCode:'b8ed23480e3c9a2ce538e85f88798e87',
    }
</script>
<script type="text/javascript">
    Dcat.ready(function () {
        //创建地图
        var map = new AMap.Map('container{{$id}}', {
            zoom: 4
        });
        AMapUI.load(['ui/misc/PathSimplifier', 'lib/$'], function (PathSimplifier, $) {

            if (!PathSimplifier.supportCanvas) {
                alert('当前环境不支持 Canvas！');
                return;
            }

            var pathSimplifierIns = new PathSimplifier({
                zIndex: 100,
                //autoSetFitView:false,
                map: map, //所属的地图实例

                getPath: function (pathData, pathIndex) {

                    return pathData.path;
                },
                getHoverTitle: function (pathData, pathIndex, pointIndex) {

                    if (pointIndex >= 0) {
                        //point
                        return pathData.name + '，点：' + pointIndex + '/' + pathData.path.length;
                    }

                    return pathData.name + '，点数量' + pathData.path.length;
                },
                renderOptions: {

                    renderAllPointsIfNumberBelow: 100 //绘制路线节点，如不需要可设置为-1
                }
            });

            window.pathSimplifierIns = pathSimplifierIns;
            var data=JSON.parse(decodeURIComponent("{{$adds}}"))
            console.log(data)
            //设置数据
            pathSimplifierIns.setData([{
                name: '路线0',
                path: data
            }]);

            //对第一条线路（即索引 0）创建一个巡航器
            var navg1 = pathSimplifierIns.createPathNavigator(0, {
                loop: true, //循环播放
                speed: 100000 //巡航速度，单位千米/小时
            });

            navg1.start();
        });
    })

</script>
