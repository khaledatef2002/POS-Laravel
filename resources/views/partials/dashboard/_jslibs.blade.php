<!-- JAVASCRIPT -->
<script src="{{ asset('assets/dashboard') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/dashboard') }}/libs/simplebar/simplebar.min.js"></script>
<script src="{{ asset('assets/dashboard') }}/libs/node-waves/waves.min.js"></script>
<script src="{{ asset('assets/dashboard') }}/libs/feather-icons/feather.min.js"></script>
<script src="{{ asset('assets/dashboard') }}/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="{{ asset('assets/dashboard') }}/js/plugins.js"></script>

<!-- apexcharts -->
<script src="{{ asset('assets/dashboard') }}/libs/apexcharts/apexcharts.min.js"></script>

<!-- Vector map-->
<script src="{{ asset('assets/dashboard') }}/libs/jsvectormap/js/jsvectormap.min.js"></script>
<script src="{{ asset('assets/dashboard') }}/libs/jsvectormap/maps/world-merc.js"></script>

<!--Swiper slider js-->
<script src="{{ asset('assets/dashboard') }}/libs/swiper/swiper-bundle.min.js"></script>

<!-- Dashboard init -->
<script src="{{ asset('assets/dashboard') }}/js/pages/dashboard-ecommerce.init.js"></script>

{{-- Jqueyr --}}
<script src="{{ asset('assets/dashboard/libs/jquery/jquery.min.js') }}"></script>

{{-- Seet Alert 2 --}}
<script src="{{ asset('assets/dashboard/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/dashboard') }}/js/app.js"></script>

{{-- Auto Ask For Delete --}}
<script>
    $(".remove-item-btn").click(function(e){
        let that = $(this)

        e.preventDefault()

        Swal.fire({
            title: "@lang('site.delete.confirm.title')",
            text: "@lang('site.delete.confirm.text')",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "@lang('site.delete.confirm')",
            cancelButtonText: "@lang('site.delete.cancel')"
        }).then((result) => {
            if (result.isConfirmed) {
                that.closest('form').submit()
            }
        });
        
    })

    $("[name='image']").change(function(){
        $(this).parent().parent().find("img").attr('src', URL.createObjectURL(event.target.files[0]))
    })

    $(".productCategoryChanger").click(function(){
        var id = $(this).data('target')
        $(`.orderProductsList li`).hide() 
        $(`.orderProductsList li[data-category='${id}']`).show() 
    })

    $(".productCategoryShowAll").click(function(){
        $(`.orderProductsList li`).show() 
    })

    $(".add-item-to-cart").click(function(){
        var id = $(this).parent().parent().parent().data('id')
        var title = $(this).parent().parent().parent().data('title')
        var price = $(this).parent().parent().parent().data('price')
        var stock = $(this).parent().parent().parent().data('stock')
        if(stock > 0)
        {
            $(".cart-table tbody").append(`
                <tr data-price="${price}">
                    <td>${title}</td>
                    <input type="hidden" name="products[]" value="${id}">
                    <td><input name="quantities[]" value="1" min="1" max="${stock}" onchange="check_max(this)" type="number" class="form-control" oninput="change_quantity(this)"></td>
                    <td>${price}</td>
                    <td><button class="btn btn-danger" onclick="remove_from_cart(this, ${id})"><i class="ri-delete-bin-line"></i></button></td>
                </tr>
            `)
            $(this).prop("disabled", true)
            calculate_total()
        }
    })

    function remove_from_cart(me, id)
    {
        $(me).parent().parent().remove()
        $(`.orderProductsList li[data-id='${id}'] button`).prop('disabled', false)
        calculate_total()
    }

    function change_quantity(me)
    {
        var quantity = ($(me).val() != "") ? $(me).val() : 0
        var single_price = ($(me).parent().parent().data('price') != "") ? $(me).parent().parent().data('price') : 0

        $(me).parent().parent().find("td").eq(2).text(quantity * single_price)
        calculate_total()
    }

    function calculate_total()
    {
        var total_price = 0
        $(".cart-table tbody tr").each( function(i , element) {
            var single_price = ($(this).data('price') != "") ? $(this).data('price') : 0;
            var quantity = ($(this).find("input[name= 'quantities[]']").val() != "") ? parseInt($(this).find("input[name= 'quantities[]']").val()) : 0
            
            total_price += (single_price * quantity)
        });
        $(".total-price").text(total_price)

        if(total_price > 0)
        {
            $('.add-order').prop("disabled", false)
        }
        else
        {
            $('.add-order').prop("disabled", true)
        }
    }

    function check_max(input)
    {
        var quantity = $(input).val()
        var max = parseInt($(input).attr("max"))
        if(quantity > max)
        {
            $(input).val(max)
            change_quantity(input)
        }   
    }

    function show_order(order_id)
    {
        var canvas = document.getElementById('order_info')
        var order_canvas = new bootstrap.Offcanvas(canvas)

        $(canvas).find(".offcanvas-body").html(`
            <div class="d-flex justify-content-center mt-4">
                <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `)
        $.get(`/dashboard/order/${order_id}`, function(data){
            $(canvas).find(".offcanvas-body").html(data)
        })
        order_canvas.show()
    }
</script>
{{-- @if (request()->route()->getName() == 'dashboard.index')
<script>
    var linechartcustomerColors = getChartColorsArray("customer_impression_charts");
    if (linechartcustomerColors) {
        var options = {
            series: [{
                name: "Orders",
                type: "area",
                data: [34, 65, 46, 68, 49, 61, 42, 44, 78, 52, 63, 67],
            },
            {
                name: "Earnings",
                type: "bar",
                data: [
                    89.25, 98.58, 68.74, 108.87, 77.54, 84.03, 51.24, 28.57, 92.57, 42.36, 88.51, 36.57,
                ],
            },
            {
                name: "Refunds",
                type: "line",
                data: [8, 12, 7, 17, 21, 11, 5, 9, 7, 29, 12, 35],
            },
            ],
            chart: {
                height: 370,
                type: "line",
                toolbar: {
                    show: false,
                },
            },
            stroke: {
                curve: "straight",
                dashArray: [0, 0, 8],
                width: [2, 0, 2.2],
            },
            fill: {
                opacity: [0.1, 0.9, 1],
            },
            markers: {
                size: [0, 0, 0],
                strokeWidth: 2,
                hover: {
                    size: 4,
                },
            },
            xaxis: {
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
            grid: {
                show: true,
                xaxis: {
                    lines: {
                        show: true,
                    },
                },
                yaxis: {
                    lines: {
                        show: false,
                    },
                },
                padding: {
                    top: 0,
                    right: -2,
                    bottom: 15,
                    left: 10,
                },
            },
            legend: {
                show: true,
                horizontalAlign: "center",
                offsetX: 0,
                offsetY: -5,
                markers: {
                    width: 9,
                    height: 9,
                    radius: 6,
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 0,
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: "30%",
                    barHeight: "70%",
                },
            },
            colors: linechartcustomerColors,
            tooltip: {
                shared: true,
                y: [{
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0);
                        }
                        return y;
                    },
                },
                {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return "$" + y.toFixed(2) + "k";
                        }
                        return y;
                    },
                },
                {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " Sales";
                        }
                        return y;
                    },
                },
                ],
            },
        };
        var chart = new ApexCharts(
            document.querySelector("#customer_impression_charts"),
            options
        );
        chart.render();
    }
</script>
@endif --}}