let util = {}

util.title = (title) => {
  title = title || 'admin'
  window.document.title = title
}

export default util
