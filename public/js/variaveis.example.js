var url_atual = window.location.href;
var retirar = url_atual.replace(/^.*\//g, '')
var urlNew = url_atual.substring(0, url_atual.search(retirar))
var url_p= urlNew
