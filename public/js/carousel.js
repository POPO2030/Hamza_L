$(function() {
  let isRtl = $("html").attr("dir") === "rtl"
  let navIcons = {
    prev: `fa fa-angle-${isRtl ? "right" : "left"}`,
    next: `fa fa-angle-${isRtl ? "left" : "right"}`
  }



  $("#slick-7-for").not('.slick-initialized').slick({
    rtl: isRtl, // Set direction
    arrows: false,
    asNavFor: "#slick-7-nav"
  })

  $("#slick-7-nav").not('.slick-initialized').slick({
    rtl: isRtl, // Set direction
    centerMode: true,
    slidesToShow: 3,
    asNavFor: "#slick-7-for",
    focusOnSelect: true,
    prevArrow: `
      <button type="button" class="btn btn-flat-primary slick-prev-2">
        <i class="${navIcons.prev}"></i>
      </button>
    `,
    nextArrow: `
      <button type="button" class="btn btn-flat-primary slick-next-2">
        <i class="${navIcons.next}"></i>
      </button>
    `
  })
})
