function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

function formatDate(date) {
    var day = String(date.getDate()).padStart(2, "0");
    var month = String(date.getMonth() + 1).padStart(2, "0"); //January is 0!
    var year = date.getFullYear();

    return year + "-" + month + "-" + day;
}

$(document).ready(function () {
    $.ajax({
        url: "/data-absensi",
        method: "GET",
        success: function (data) {
            let labels = [];
            let counts = [];
            let lateCounts = [];
            let notPresentCounts = [];

            let monthNames = [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ];

            let countsByDate = {};
            let lateCountsByDate = {};
            let notPresentCountsByDate = {};

            for (let item of data[0]) {
                countsByDate[item.date] = item.count;
            }

            for (let item of data[1]) {
                lateCountsByDate[item.date] = item.count;
            }

            for (let item of data[2]) {
                notPresentCountsByDate[item.date] = item.count;
            }

            for (let i = 6; i >= 0; i--) {
                // changed > to >=
                let d = new Date();
                d.setDate(d.getDate() - i);
                let dateString = formatDate(d);

                labels.push(`${d.getDate()} ${monthNames[d.getMonth()]}`);
                counts.push(countsByDate[dateString] || 0);
                lateCounts.push(lateCountsByDate[dateString] || 0);
                notPresentCounts.push(notPresentCountsByDate[dateString] || 0);
            }

            var ctx = document.getElementById("myAreaChart");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Tepat Waktu",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "#1cc88a",
                            pointRadius: 3,
                            pointBackgroundColor: "#1cc88a",
                            pointBorderColor: "#1cc88a",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#1cc88a",
                            pointHoverBorderColor: "#1cc88a",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: counts,
                        },
                        {
                            label: "Terlambat",
                            lineTension: 0.3,
                            backgroundColor: "rgba(220, 53, 69, 0.05)",
                            borderColor: "#dc3545",
                            pointRadius: 3,
                            pointBackgroundColor: "#dc3545",
                            pointBorderColor: "#dc3545",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#dc3545",
                            pointHoverBorderColor: "#dc3545",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: lateCounts,
                        },
                        {
                            label: "Tidak Absen",
                            lineTension: 0.3,
                            backgroundColor: "rgba(220, 53, 69, 0.05)",
                            borderColor: "#f6c23e",
                            pointRadius: 3,
                            pointBackgroundColor: "#f6c23e",
                            pointBorderColor: "#f6c23e",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "#f6c23e",
                            pointHoverBorderColor: "#f6c23e",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: notPresentCounts,
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0,
                        },
                    },
                    scales: {
                        x: {
                            time: {
                                unit: "date",
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                maxTicksLimit: 7,
                            },
                        },
                        y: {
                            min: 0,
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return number_format(value);
                                },
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2],
                            },
                        },
                    },
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: "#6e707e",
                        titleFontSize: 14,
                        borderColor: "#dddfeb",
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: "index",
                        caretPadding: 10,
                        callbacks: {
                            label: function (tooltipItem, chart) {
                                var datasetLabel =
                                    chart.datasets[tooltipItem.datasetIndex]
                                        .label || "";
                                return (
                                    datasetLabel +
                                    ": " +
                                    number_format(tooltipItem.yLabel)
                                );
                            },
                        },
                    },
                },
            });
        },
    });
});
