function changeDate(days) {
  curdate = location.href.replace(/.*date=/, "")
  d = isNaN(new Date(curdate).getTime()) ? new Date() : new Date(curdate)
  d.setDate(d.getDate() + days)
  isod = d.toISOString().split("T")[0]
  location.href = location.href.search(/(date=)[^\&]+/) === -1 ? location.href + "?date=" + isod : location.href.replace(/(date=)[^\&]+/, '$1' + isod)
}
