$(function() {
  // Set default theme variation variables
  const isDarkDefault = localStorage.getItem("theme-variant") == "dark"
  const themeVariantDefault = isDarkDefault ? "dark" : "light"

  // Chart theme options
  const themeOptions = {
    light: {
      theme: {
        mode: "light",
        palette: "palette1"
      }
    },
    dark: {
      theme: {
        mode: "dark",
        palette: "palette1"
      }
    }
  }


  const chart2 = new ApexCharts(document.querySelector("#apexchart-2"), {
    ...themeOptions[themeVariantDefault],
    series: [
      {
        name: "series1",
        data: [31, 40, 28, 51, 42, 109, 100]
      },
      {
        name: "series2",
        data: [11, 32, 45, 32, 34, 52, 41]
      }
    ],
    chart: {
      height: 350,
      type: "area",
      background: "transparent"
    },
    fill: { type: "gradient" },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: "smooth"
    },
    xaxis: {
      type: "datetime",
      categories: [
        "2018-09-18T00:00:00.000Z",
        "2018-09-19T01:30:00.000Z",
        "2018-09-19T02:30:00.000Z",
        "2018-09-19T03:30:00.000Z",
        "2018-09-19T04:30:00.000Z",
        "2018-09-19T05:30:00.000Z",
        "2018-09-19T06:30:00.000Z"
      ]
    },
    tooltip: {
      x: {
        format: "dd/MM/yy HH:mm"
      }
    }
  })

  // Render all chart widgets

  chart2.render()


  // Theme toggle listener
  $("#theme-toggle").on("click", function() {
    console.log("dara");
    let isDark = $("body").hasClass("theme-dark")
    let themeVariant = isDark ? "dark" : "light"

    // Update all widget colors
    chart2.updateOptions(themeOptions[themeVariant])

  })
})
