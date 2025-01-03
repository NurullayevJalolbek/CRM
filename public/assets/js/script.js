(function ($) {
    "use strict"; var $wrapper = $('.main-wrapper'); var $pageWrapper = $('.page-wrapper'); var $slimScrolls = $('.slimscroll'); var Sidemenu = function () { this.$menuItem = $('#sidebar-menu a'); }; function init() {
        var $this = Sidemenu; $('#sidebar-menu a').on('click', function (e) {
            if ($(this).parent().hasClass('submenu')) { e.preventDefault(); }
            if (!$(this).hasClass('subdrop')) { $('ul', $(this).parents('ul:first')).slideUp(350); $('a', $(this).parents('ul:first')).removeClass('subdrop'); $(this).next('ul').slideDown(350); $(this).addClass('subdrop'); } else if ($(this).hasClass('subdrop')) { $(this).removeClass('subdrop'); $(this).next('ul').slideUp(350); }
        }); $('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
    }
    init(); $('body').append('<div class="sidebar-overlay"></div>'); $(document).on('click', '#mobile_btn', function () { $wrapper.toggleClass('slide-nav'); $('.sidebar-overlay').toggleClass('opened'); $('html').addClass('menu-opened'); return false; }); if ($('.toggle-password').length > 0) { $(document).on('click', '.toggle-password', function () { $(this).toggleClass("feather-eye feather-eye-off"); var input = $(".pass-input"); if (input.attr("type") == "password") { input.attr("type", "text"); } else { input.attr("type", "password"); } }); }
    if ($('.reg-toggle-password').length > 0) { $(document).on('click', '.reg-toggle-password', function () { $(this).toggleClass("feather-eye feather-eye-off"); var input = $(".pass-confirm"); if (input.attr("type") == "password") { input.attr("type", "text"); } else { input.attr("type", "password"); } }); }
    $(".sidebar-overlay").on("click", function () { $wrapper.removeClass('slide-nav'); $(".sidebar-overlay").removeClass("opened"); $('html').removeClass('menu-opened'); }); $(document).on("click", ".logo-hide-btn", function () { $(this).parent().hide(); }); if ($('.page-wrapper').length > 0) { var height = $(window).height(); $(".page-wrapper").css("min-height", height); }
    // $(window).resize(function () { if ($('.page-wrapper').length > 0) { var height = $(window).height(); $(".page-wrapper").css("min-height", height); } }); if ($('.select').length > 0) { $('.select').select2({ minimumResultsForSearch: -1, width: '100%' }); }
    if ($('#editor').length > 0) { ClassicEditor.create(document.querySelector('#editor'), { toolbar: { items: ['heading', '|', 'fontfamily', 'fontsize', '|', 'alignment', '|', 'fontColor', 'fontBackgroundColor', '|', 'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|', 'link', '|', 'outdent', 'indent', '|', 'bulletedList', 'numberedList', 'todoList', '|', 'code', 'codeBlock', '|', 'insertTable', '|', 'uploadImage', 'blockQuote', '|', 'undo', 'redo'], shouldNotGroupWhenFull: true } }).then(editor => { window.editor = editor; }).catch(err => { console.error(err.stack); }); }
    $(".settings-form").on('click', '.trash', function () { $(this).closest('.links-cont').remove(); return false; }); $(document).on("click", ".add-links", function () {
        var experiencecontent = '<div class="row form-row links-cont">' +
            '<div class="form-group d-flex">' +
            '<button class="btn social-icon"><i class="feather-github"></i></button>' +
            '<input type="text" class="form-control" placeholder="Social Link">' +
            '<div><a href="#" class="btn trash"><i class="feather-trash-2"></i></a></div>' +
            '</div>' +
            '</div>'; $(".settings-form").append(experiencecontent); return false;
    });
    //  if ($('.datetimepicker').length > 0) { $('.datetimepicker').datetimepicker({ format: 'DD-MM-YYYY', icons: { up: "fas fa-angle-up", down: "fas fa-angle-down", next: 'fas fa-angle-right', previous: 'fas fa-angle-left' } }); $('.datetimepicker').on('dp.show', function () { $(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp'); }).on('dp.hide', function () { $(this).closest('.temp').addClass('table-responsive').removeClass('temp') }); }
    if ($('[data-toggle="tooltip"]').length > 0) { $('[data-toggle="tooltip"]').tooltip(); }
    // if ($('.datatable').length > 0) { $('.datatable').DataTable({ "bFilter": false, }); }
    // if ($('.datatables').length > 0) { $('.datatables').DataTable({ "bFilter": true, }); }
    if ($('.zoom-screen .header-nav-list').length > 0) { $('.zoom-screen .header-nav-list').on('click', function (e) { if (!document.fullscreenElement) { document.documentElement.requestFullscreen(); } else { if (document.exitFullscreen) { document.exitFullscreen(); } } }) }
    $(document).on('click', '#check_all', function () { $('.checkmail').click(); return false; }); if ($('.checkmail').length > 0) { $('.checkmail').each(function () { $(this).on('click', function () { if ($(this).closest('tr').hasClass('checked')) { $(this).closest('tr').removeClass('checked'); } else { $(this).closest('tr').addClass('checked'); } }); }); }
    $(document).on('click', '.mail-important', function () { $(this).find('i.fa').toggleClass('fa-star').toggleClass('fa-star-o'); }); if ($('.summernote').length > 0) { $('.summernote').summernote({ height: 200, minHeight: null, maxHeight: null, focus: false }); }
    if ($slimScrolls.length > 0) { $slimScrolls.slimScroll({ height: 'auto', width: '100%', position: 'right', size: '7px', color: '#ccc', allowPageScroll: false, wheelStep: 10, touchScrollStep: 100 }); var wHeight = $(window).height() - 60; $slimScrolls.height(wHeight); $('.sidebar .slimScrollDiv').height(wHeight); $(window).resize(function () { var rHeight = $(window).height() - 60; $slimScrolls.height(rHeight); $('.sidebar .slimScrollDiv').height(rHeight); }); }
    $(document).on('click', '#toggle_btn', function () {
        if ($('body').hasClass('mini-sidebar')) { $('body').removeClass('mini-sidebar'); $('.subdrop + ul').slideDown(); } else { $('body').addClass('mini-sidebar'); $('.subdrop + ul').slideUp(); }
        setTimeout(function () { }, 300); return false;
    }); $(document).on('mouseover', function (e) {
        e.stopPropagation(); if ($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
            var targ = $(e.target).closest('.sidebar').length; if (targ) { $('body').addClass('expand-menu'); $('.subdrop + ul').slideDown(); } else { $('body').removeClass('expand-menu'); $('.subdrop + ul').slideUp(); }
            return false;
        }
    }); function animateElements() { $('.circle-bar1').each(function () { var elementPos = $(this).offset().top; var topOfWindow = $(window).scrollTop(); var percent = $(this).find('.circle-graph1').attr('data-percent'); var animate = $(this).data('animate'); if (elementPos < topOfWindow + $(window).height() - 30 && !animate) { $(this).data('animate', true); $(this).find('.circle-graph1').circleProgress({ value: percent / 100, size: 400, thickness: 30, fill: { color: '#6e6bfa' } }); } }); $('.circle-bar2').each(function () { var elementPos = $(this).offset().top; var topOfWindow = $(window).scrollTop(); var percent = $(this).find('.circle-graph2').attr('data-percent'); var animate = $(this).data('animate'); if (elementPos < topOfWindow + $(window).height() - 30 && !animate) { $(this).data('animate', true); $(this).find('.circle-graph2').circleProgress({ value: percent / 100, size: 400, thickness: 30, fill: { color: '#6e6bfa' } }); } }); $('.circle-bar3').each(function () { var elementPos = $(this).offset().top; var topOfWindow = $(window).scrollTop(); var percent = $(this).find('.circle-graph3').attr('data-percent'); var animate = $(this).data('animate'); if (elementPos < topOfWindow + $(window).height() - 30 && !animate) { $(this).data('animate', true); $(this).find('.circle-graph3').circleProgress({ value: percent / 100, size: 400, thickness: 30, fill: { color: '#6e6bfa' } }); } }); }
    if ($('.circle-bar').length > 0) { animateElements(); }
    $(window).scroll(animateElements); $(window).on('load', function () { if ($('#loader').length > 0) { $('#loader').delay(350).fadeOut('slow'); $('body').delay(350).css({ 'overflow': 'visible' }); } })
    $('.app-listing .selectBox').on("click", function () { $(this).parent().find('#checkBoxes').fadeToggle(); $(this).parent().parent().siblings().find('#checkBoxes').fadeOut(); }); $('.invoices-main-form .selectBox').on("click", function () { $(this).parent().find('#checkBoxes-one').fadeToggle(); $(this).parent().parent().siblings().find('#checkBoxes-one').fadeOut(); }); if ($('.SortBy').length > 0) { var show = true; var checkbox1 = document.getElementById("checkBox"); $('.selectBoxes').on("click", function () { if (show) { checkbox1.style.display = "block"; show = false; } else { checkbox1.style.display = "none"; show = true; } }); }
    $(function () { $("input[name='invoice']").click(function () { if ($("#chkYes").is(":checked")) { $("#show-invoices").show(); } else { $("#show-invoices").hide(); } }); }); $(".links-info-one").on('click', '.service-trash', function () { $(this).closest('.links-cont').remove(); return false; }); $(document).on("click", ".add-links", function () {
        var experiencecontent = '<div class="links-cont">' +
            '<div class="service-amount">' +
            '<a href="#" class="service-trash"><i class="fe fe-minus-circle me-1"></i>Service Charge</a> <span>$ 4</span' +
            '</div>' +
            '</div>'; $(".links-info-one").append(experiencecontent); return false;
    }); $(".links-info-discount").on('click', '.service-trash-one', function () { $(this).closest('.links-cont-discount').remove(); return false; }); $(document).on("click", ".add-links-one", function () {
        var experiencecontent = '<div class="links-cont-discount">' +
            '<div class="service-amount">' +
            '<a href="#" class="service-trash-one"><i class="fe fe-minus-circle me-1"></i>Offer new</a> <span>$ 4 %</span' +
            '</div>' +
            '</div>'; $(".links-info-discount").append(experiencecontent); return false;
    }); if ($('#summernote').length > 0) { $('#summernote').summernote({ height: 300, minHeight: null, maxHeight: null, focus: true }); }
    if ($('.counter').length > 0) { $('.counter').counterUp({ delay: 20, time: 2000 }); }
    if ($('#timer-countdown').length > 0) { $('#timer-countdown').countdown({ from: 180, to: 0, movingUnit: 1000, timerEnd: undefined, outputPattern: '$day Day $hour : $minute : $second', autostart: true }); }
    if ($('#timer-countup').length > 0) { $('#timer-countup').countdown({ from: 0, to: 180 }); }
    if ($('#timer-countinbetween').length > 0) { $('#timer-countinbetween').countdown({ from: 30, to: 20 }); }
    if ($('#timer-countercallback').length > 0) { $('#timer-countercallback').countdown({ from: 10, to: 0, timerEnd: function () { this.css({ 'text-decoration': 'line-through' }).animate({ 'opacity': .5 }, 500); } }); }
    if ($('#timer-outputpattern').length > 0) { $('#timer-outputpattern').countdown({ outputPattern: '$day Days $hour Hour $minute Min $second Sec..', from: 60 * 60 * 24 * 3 }); }
    if ($('[data-bs-toggle="tooltip"]').length > 0) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl) })
    }
    if ($('.popover-list').length > 0) {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) { return new bootstrap.Popover(popoverTriggerEl) })
    }
    if ($('.clipboard').length > 0) { var clipboard = new Clipboard('.btn'); }
    $(".add-table-items").on('click', '.remove-btn', function () { $(this).closest('.add-row').remove(); return false; }); $(document).on("click", ".add-btn", function () {
        var experiencecontent = '<tr class="add-row">' +
            '<td>' +
            '<input type="text" class="form-control">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control">' +
            '</td>' +
            '<td>' +
            '<input type="text" class="form-control">' +
            '</td>' +
            '<td class="add-remove text-end">' +
            '<a href="javascript:void(0);" class="add-btn me-2"><i class="fas fa-plus-circle"></i></a> ' +
            '<a href="#" class="copy-btn me-2"><i class="fe fe-copy"></i></a>' +
            '<a href="javascript:void(0);" class="remove-btn"><i class="fe fe-trash-2"></i></a>' +
            '</td>' +
            '</tr>'; $(".add-table-items").append(experiencecontent); return false;
    }); feather.replace();

    document.addEventListener('DOMContentLoaded', function () {
        // Get all input elements
        var inputs = document.querySelectorAll('input[type="tel"]');

        // Function to set default value to +998
        var setDefaultValue = function (input) {
            if (!input.value.startsWith('+998 ')) {
                input.value = '+998 ';
            }
        };

        // Set default value for all inputs and add input event listeners
        inputs.forEach(function (input) {
            setDefaultValue(input);
            input.addEventListener('input', function (e) {
                setDefaultValue(e.target);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener to "Bekor qilish" button to close the modal
        document.getElementById('submitBtn').addEventListener('click', function() {
            document.getElementById('ustozForm').submit(); // Submit the form
        });

        // Example: Set payment ID dynamically when modal is opened
        $('#ustozModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var paymentId = button.data('payment-id'); // Extract payment ID from data-* attributes
            document.getElementById('paymentIdInput').value =
            paymentId; // Set the payment ID in the hidden input
        });
    });





    $(document).ready(function () {
        // Get the current URL
        var url = window.location.href;

        // Initialize variable to store last clicked element
        var lastClicked = null;

        // Find the link that matches the current URL
        $(".sidebar-menu ul li a").each(function () {
            if ($(this).attr("href") === url) {
                $(this).addClass("active");
                $(this).closest('.submenu').addClass("active");
                $(this).closest('.sidebar-menu ul .submenu ul').addClass("dblockuz");

                // Store the last clicked element
                lastClicked = $(this);
            }
        });

        // Remove active class from all elements except the last clicked
        $(".sidebar-menu ul li a").click(function () {
            if (lastClicked !== null && lastClicked !== $(this)) {
                lastClicked.removeClass("active");
                lastClicked.closest('.submenu').removeClass("active");
                lastClicked.closest('.sidebar-menu ul .submenu ul').removeClass("dblockuz");
            }

            // Add active class to the clicked element
            $(this).addClass("active");
            $(this).closest('.submenu').addClass("active");
            $(this).closest('.sidebar-menu ul .submenu ul').addClass("dblockuz");

            // Update last clicked element
            lastClicked = $(this);
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
        // Hide the loading spinner when the page is fully loaded
        const loadingSpinner = document.getElementById('loading-spinner');
        loadingSpinner.style.display = 'none';
    });




    let subjectDropdown = document.getElementById("subject");
    let groupsDropdown = document.getElementById('groups');

    subjectDropdown.addEventListener('change', () => {
        let subjectId = subjectDropdown.value;

        // Clear previous options
        groupsDropdown.innerHTML = '';

        // Fetch groups based on selected subject via AJAX
        fetch(`/subjects/${subjectId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch groups');
                }
                return response.json(); // Return parsed JSON response
            })
            .then(groups => {
                console.log("Groups:", groups);
                groups.forEach(group => {
                    let option = document.createElement('option');
                    option.value = group.id;
                    option.textContent = group.name;
                    groupsDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching groups:', error);
            });
    });


    // Assuming you're using jQuery for simplicity
    $('input[type="radio"]').change(function () {
        var value = $(this).val();
        var studentId = $(this).attr('name').replace('attendance[', '').replace(']', '');
        $('input[name="status[' + studentId + ']"]').val(value);
    });


    "use strict";

    // Initialize Select2 for elements with class 'js-select2'
    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: " Click to select an group",
        allowHtml: true,
        allowClear: true
    });

    // Initialize Select2 for elements with class 'icons_select2'
    $('.icons_select2').select2({
        width: "100%",
        templateSelection: formatSelection,
        templateResult: formatResult,
        allowHtml: true,
        placeholder: " Click to select an group",
        dropdownParent: $('.select-icon'), // Specify the parent element for the dropdown
        allowClear: true,
        multiple: false
    });

    // Function to format selected option
    function formatSelection(icon, badge) {
        var originalOption = icon.element;
        var originalOptionBadge = $(originalOption).data('badge');

        return $('<span><i class="fa ' + $(originalOption).data('icon') + '"> </i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
    }

    // Function to format result in the dropdown
    function formatResult(icon, badge) {
        var originalOption = icon.element;
        var originalOptionBadge = $(originalOption).data('badge');

        return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
    }


    $(document).ready(function () {
        $('.preview-btn').click(function () {
            var receiptId = $(this).data('receipt-id');

            $.ajax({
                url: '/fetch-receipt-info', // Replace this with your actual route URL
                type: 'GET',
                data: {
                    receiptId: receiptId
                },
                success: function (response) {

                    const groupPriceFormatted = new Intl.NumberFormat('uz-UZ', {
                        style: 'currency',
                        currency: 'UZS'
                    }).format(response.group_price);

                    const paidAmountFormatted = new Intl.NumberFormat('uz-UZ', {
                        style: 'currency',
                        currency: 'UZS'
                    }).format(response.paid_amount);

                    $('#previewCheck .id').text(response.id);
                    $('#previewCheck .student-name').text(response.student_name);
                    $('#previewCheck .payment_method').text(response.payment_method);
                    $('#previewCheck .group-name').text(response.group_name);
                    $('#previewCheck .group-price').text(groupPriceFormatted);
                    $('#previewCheck .group-teacher').text(response.group_teacher);
                    $('#previewCheck .paid-amount').text(paidAmountFormatted);
                    $('#previewCheck .created-at').text(response.created_at);

                    // Show the modal
                    $('#previewCheck').modal('show');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
        var closeModalButtons = document.querySelectorAll('.modal .close, .modal [data-dismiss="modal"]');
        closeModalButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var modal = button.closest('.modal');
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
                var modalBackdrops = document.getElementsByClassName('modal-backdrop');
                [].forEach.call(modalBackdrops, function (modalBackdrop) {
                    modalBackdrop.parentNode.removeChild(modalBackdrop);
                });
            });
        });
    });



    function printReceipt() {
        // Open a new window
        var printWindow = window.open('', '_blank');

        // Write the HTML content to the new window
        printWindow.document.write('<html><head><title>Receipt</title>');
        printWindow.document.write('<link rel="stylesheet" href="/assets/css/style.css" type="text/css" media="print"/>');
        printWindow.document.write('<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css" type="text/css" media="print"/>');
        printWindow.document.write('</head><body>');

        // Get the receipt container
        var receiptContainer = document.getElementById('receiptToPrint');

        // Append the printable content to the new window
        printWindow.document.write(receiptContainer.innerHTML);

        // Close the HTML body and HTML document
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Wait for images and styles to load before printing
        printWindow.addEventListener('load', function () {
            // Trigger printing
            printWindow.print();
            // Close the new window after printing
            printWindow.close();
        });
    }

    // Event listener for the print button
    var printBtn = document.getElementById('printReceiptBtn');
    printBtn.addEventListener('click', printReceipt);


    function setActiveTab(tabId) {
        localStorage.setItem('activeTab', tabId);
    }

    // Function to get the active tab from local storage
    function getActiveTab() {
        return localStorage.getItem('activeTab');
    }

    // When a tab is shown, set it as the active tab in local storage
    $('#myTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tabId = e.target.getAttribute('href');
        setActiveTab(tabId);
    });

    // When the page loads, activate the tab stored in local storage
    $(document).ready(function () {
        var activeTabId = getActiveTab();
        if (activeTabId) {
            $('#myTabs a[href="' + activeTabId + '"]').tab('show');
        }
    });
    
})(jQuery);



document.addEventListener('DOMContentLoaded', function () {
    const changeStatusCheckbox = document.getElementById('flexSwitchCheckDefault'); // Update the ID here
    const changeStatusInput = document.getElementById('changeStatus');

    if (changeStatusCheckbox && changeStatusInput) { // Check if the elements are found
        changeStatusCheckbox.addEventListener('change', function () {
            if (this.checked) {
                changeStatusInput.value = 1; // Set the value to indicate status change
            } else {
                changeStatusInput.value = 0; // Reset the value if unchecked
            }
        });
    }
});



const monthYearElement = document.getElementById('monthYear');
const daysGridElement = document.getElementById('daysGrid');
const weekDaysElement = document.getElementById('weekDays');

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

function displayCalendar(month, year) {
    let daysInMonth = 32 - new Date(year, month, 32).getDate();
    let date = 1;


    let html = '';


    const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    html = '';
    html += '<tr>';
    for (let i = 0; i < daysInMonth; i++) {
        let dayOfWeek = new Date(year, month, date).getDay();
        html += `<td><div>${weekDays[dayOfWeek]}</div><div>${date}</div></td>`;
        date++;
    }
    html += '</tr>';
}

function getMonthName(month) {
    const months = [
        'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
    ];
    return months[month];
}

function prevMonth() {
    currentMonth -= 1;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear -= 1;
    }
    displayCalendar(currentMonth, currentYear);
}

function nextMonth() {
    currentMonth += 1;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear += 1;
    }
    displayCalendar(currentMonth, currentYear);
}

displayCalendar(currentMonth, currentYear);

