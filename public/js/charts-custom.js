$(document).ready(function () {

    'use strict';

    var brandPrimary = 'rgba(51, 179, 90, 1)';
    var SALECHART    = $('#saleChart');

    if (SALECHART.length > 0) {
        var yearly_sale_amount = SALECHART.data('sale_chart_value');
        var yearly_purchase_amount = SALECHART.data('purchase_chart_value');
        /*var saleChart = new Chart(SALECHART, {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [
                    {
                        label: "Purchase Amount",
                        backgroundColor: [
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)',
                            'rgba(203, 203, 203, 0.6)'
                        ],
                        borderColor: [
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)',
                            'rgba(203, 203, 203, 1)'
                        ],
                        borderWidth: 1,
                        data: [ yearly_purchase_amount[0], yearly_purchase_amount[1],
                                yearly_purchase_amount[2], yearly_purchase_amount[3],
                                yearly_purchase_amount[4], yearly_purchase_amount[5],
                                yearly_purchase_amount[6], yearly_purchase_amount[7],
                                yearly_purchase_amount[8], yearly_purchase_amount[9],
                                yearly_purchase_amount[10], yearly_purchase_amount[11],
                                0],
                    },
                    {
                        label: "Sale Amount",
                        backgroundColor: [
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)'
                        ],
                        borderColor: [
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)'
                        ],
                        borderWidth: 1,
                        data: [ yearly_sale_amount[0], yearly_sale_amount[1],
                                yearly_sale_amount[2], yearly_sale_amount[3],
                                yearly_sale_amount[4], yearly_sale_amount[5],
                                yearly_sale_amount[6], yearly_sale_amount[7],
                                yearly_sale_amount[8], yearly_sale_amount[9],
                                yearly_sale_amount[10], yearly_sale_amount[11],
                                0],
                    },
                ]
            }
        });*/

        var saleChart = new Chart(SALECHART, {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [
                    {
                        label: "Purchase Amount",
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: "rgba(51, 179, 90, 0.38)",
                        borderColor: brandPrimary,
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 1,
                        pointBorderColor: brandPrimary,
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: brandPrimary,
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [ yearly_purchase_amount[0], yearly_purchase_amount[1],
                                yearly_purchase_amount[2], yearly_purchase_amount[3],
                                yearly_purchase_amount[4], yearly_purchase_amount[5],
                                yearly_purchase_amount[6], yearly_purchase_amount[7],
                                yearly_purchase_amount[8], yearly_purchase_amount[9],
                                yearly_purchase_amount[10], yearly_purchase_amount[11] ],
                        spanGaps: false
                    },
                    {
                        label: "Sale Amount",
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 1,
                        pointBorderColor: "rgba(75,192,192,1)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [ yearly_sale_amount[0], yearly_sale_amount[1],
                                yearly_sale_amount[2], yearly_sale_amount[3],
                                yearly_sale_amount[4], yearly_sale_amount[5],
                                yearly_sale_amount[6], yearly_sale_amount[7],
                                yearly_sale_amount[8], yearly_sale_amount[9],
                                yearly_sale_amount[10], yearly_sale_amount[11] ],
                        spanGaps: false
                    }
                ]
            }
        });
    }

    var BESTSELLER    = $('#bestSeller');

    if (BESTSELLER.length > 0) {
        var sold_qty = BESTSELLER.data('sold_qty');
        var product_info = BESTSELLER.data('product');
        var bestSeller = new Chart(BESTSELLER, {
            type: 'bar',
            data: {
                labels: [ product_info[0], product_info[1], product_info[2]],
                datasets: [
                    {
                        label: "Sale Qty",
                        backgroundColor: [
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)'
                        ],
                        borderColor: [
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)'
                        ],
                        borderWidth: 1,
                        data: [ 
                                sold_qty[0], sold_qty[1],
                                sold_qty[2], 0],
                    }
                ]
            }
        });
    }

    var PIECHART = $('#pieChart');
    var price = PIECHART.data('price');
    var cost = PIECHART.data('cost');
    var myPieChart = new Chart(PIECHART, {
        type: 'doughnut',
        data: {
            labels: [
                "Stock Value by Price",
                "Stock Value by Cost",
                "Estimate Profit"
            ],
            datasets: [
                {
                    data: [price, cost, price-cost],
                    borderWidth: [1, 1, 1],
                    backgroundColor: [
                        brandPrimary,
                        "rgba(75,192,192,1)",
                        "#FFCE56"
                    ],
                    hoverBackgroundColor: [
                        brandPrimary,
                        "rgba(75,192,192,1)",
                        "#FFCE56"
                    ]
                }]
        }
    });
});
