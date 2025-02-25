@extends('admin.layout.index')
@section('title')
Trang chủ quản lý văn bản hành chính
@endsection
@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Trang chủ
                        </h1>
                    </div>
                <table style="width: 100%;border-collapse: collapse;">
                    <tr>
                        <td>
                            <div class="line_chart" style="display: flex; flex-direction: column; align-items: center;">
                                <label style="font-size: 20px; margin-bottom: 5px;">{{ $dangxuly }}</label>
                                <p class="home-chart" style="color: rgb(15, 82, 141); font-size: 15px;">Văn bản đang xử lý</p>
                            </div>
                                                                                
                        </td>
                        <td>
                            <div class="line_chart" style="display: flex; flex-direction: column; align-items: center;">
                                <label style="font-size: 20px; margin-bottom: 5px;">{{ $vanbanden }}</label>
                                <p class="home-chart" style="color: rgb(69, 204, 35); font-size: 15px;">Văn bản đến</p>
                            </div>
                        </td>
                        <td>
                            <div class="line_chart" style="display: flex; flex-direction: column; align-items: center;">
                                <label style="font-size: 20px; margin-bottom: 5px;">{{ $vanbandi }}</label>
                                <p class="home-chart" style="color: rgb(71, 40, 56); font-size: 15px;">Văn bản đi</p>
                            </div>
                        </td>
                        <td>
                            <div class="line_chart" style="display: flex; flex-direction: column; align-items: center;">
                                <label style="font-size: 20px; margin-bottom: 5px;">{{ $vanbannoibo }}</label>
                                <p class="home-chart" style="color: rgb(15, 82, 141); font-size: 15px;">Văn bản nội bộ</p>
                            </div>
                        </td>
                    </tr>
                    
                </table>
                </div>
                <div class="wrapper">
                    <canvas id="myChart"></canvas>
                </div>
                
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
                  <script>
                    var ctx = document.getElementById('myChart').getContext("2d");
                
                    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                    gradientStroke.addColorStop(0, "#80b6f4");
                    gradientStroke.addColorStop(1, "#f49080");
                
                    var myChart = new Chart(ctx, {
                      type: 'line',
                      data: {
                          labels: ["Văn bản đi", "Văn bản đến", "Văn bản nội bộ", "Văn bản đang xử lý"],
                          datasets: [{
                              label: "Thông kê văn bản",
                              borderColor: gradientStroke,
                              pointBorderColor: gradientStroke,
                              pointBackgroundColor: gradientStroke,
                              pointHoverBackgroundColor: gradientStroke,
                              pointHoverBorderColor: gradientStroke,
                              pointBorderWidth: 10,
                              pointHoverRadius: 10,
                              pointHoverBorderWidth: 1,
                              pointRadius: 3,
                              fill: false, // If true, fill the area under the line.
                              borderWidth: 4,
                              data: [{{ $vanbandi }} , {{ $vanbanden }}, {{ $vanbannoibo }}, {{ $dangxuly }}]
                          }]
                      },
                      options: {
                          legend: {
                              position: "bottom"
                          },
                          scales: {
                              yAxes: [{
                                  ticks: {
                                      fontColor: "rgba(0,0,0,0.5)",
                                      fontStyle: "bold",
                                      beginAtZero: true, // If true, scale will include 0 if it is not already included.
                                      maxTicksLimit: 5,  // Maximum number of ticks and gridlines to show.
                                      padding: 20        // Padding between the tick label and the axis.
                                  },
                                  gridLines: {
                                      drawTicks: false, // If true, draw lines beside the ticks in the axis area beside the chart.
                                      display: false
                                  }
                              }],
                              xAxes: [{
                                  gridLines: {
                                      zeroLineColor: "transparent" // Stroke color of the grid line for the first index (index 0).
                                  },
                                  ticks: {
                                      padding: 20,
                                      fontColor: "rgba(0,0,0,0.5)",
                                      fontStyle: "bold"
                                  }
                              }]
                          }
                      }
                    });
                  </script>
                <div id="clock">
                  
                </div>

                <script>
                    function updateClock() {
                        const now = new Date();
                        let hours = now.getHours();
                        let minutes = now.getMinutes();
                        let seconds = now.getSeconds();
                        
                        // Thêm số 0 đằng trước nếu cần
                        hours = hours < 10 ? "0" + hours : hours;
                        minutes = minutes < 10 ? "0" + minutes : minutes;
                        seconds = seconds < 10 ? "0" + seconds : seconds;
                        
                        const timeString = `${hours}:${minutes}:${seconds}`;
                        document.getElementById('clock').innerHTML = timeString;
                    }
            
                    // Cập nhật đồng hồ ngay lập tức và sau đó mỗi giây
                    updateClock();
                    setInterval(updateClock, 1000);
                </script>
                  <div class="wrapper-2">
                    <header>
                      <p class="current-date"></p>
                      <div class="icons">
                        <span id="prev" class="material-symbols-rounded"><i class="fa-solid fa-left-long"></i></span>
                        <span id="next" class="material-symbols-rounded"><i class="fa-solid fa-right-long"></i></i></span>
                      </div>
                    </header>
                    <div class="calendar">
                      <ul class="weeks">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                      </ul>
                      <ul class="days"></ul>
                    </div>
                  </div>
                  <script>
                    const daysTag = document.querySelector(".days"),
                    currentDate = document.querySelector(".current-date"),
                    prevNextIcon = document.querySelectorAll(".icons span");
                    // getting new date, current year and month
                    let date = new Date(),
                    currYear = date.getFullYear(),
                    currMonth = date.getMonth();
                    // storing full name of all months in array
                    const months = ["January", "February", "March", "April", "May", "June", "July",
                                "August", "September", "October", "November", "December"];
                    const renderCalendar = () => {
                        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
                        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
                        lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
                        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
                        let liTag = "";
                        for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
                            liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
                        }
                        for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
                            // adding active class to li if the current day, month, and year matched
                            let isToday = i === date.getDate() && currMonth === new Date().getMonth() 
                                        && currYear === new Date().getFullYear() ? "active" : "";
                            liTag += `<li class="${isToday}">${i}</li>`;
                        }
                        for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
                            liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
                        }
                        currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
                        daysTag.innerHTML = liTag;
                    }
                    renderCalendar();
                    prevNextIcon.forEach(icon => { // getting prev and next icons
                        icon.addEventListener("click", () => { // adding click event on both icons
                            // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
                            currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
                            if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
                                // creating a new date of current year & month and pass it as date value
                                date = new Date(currYear, currMonth, new Date().getDate());
                                currYear = date.getFullYear(); // updating current year with new date year
                                currMonth = date.getMonth(); // updating current month with new date month
                            } else {
                                date = new Date(); // pass the current date as date value
                            }
                            renderCalendar(); // calling renderCalendar function
                        });
                    });
                  </script>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

@endsection