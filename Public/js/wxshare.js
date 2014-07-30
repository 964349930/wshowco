// set the wechat share option
function wxshare() {
  var wxjs = WeixinJSBridge;
  wxjs.on("menu:share:appmessage", e),
  wxjs.on("menu:share:weibo", f),
  wxjs.on("menu:share:timeline", g),
  //wxjs.invoke("getNetworkType", {}, getnetworktype)
}

// get the client network type by weixinjsbridge
// function getnetworktype(wxjs) {
//   var b, c;
//   switch (a.err_msg) {
//   case "network_type:wwan":
//     b = 2e3;
//     break;
//   case "network_type:edge":
//     b = 3e3;
//     break;
//   case "network_type:wifi":
//     b = 4e3
//   }
//   c = new Image,
//   c.onerror = c.onload = function () {
//     c = null
//   }
// }


function e() {
  var send2friendmsg = window.shareData.send2Friend,
  WeixinJSBridge.invoke("sendAppMessage", {
    img_url: send2friendmsg.img,
    img_width: "640",
    img_height: "640",
    link: send2friendmsg.link,
    desc: send2friendmsg.content,
    title: send2friendmsg.title
  },function () { })
}

function share() {
  var b = window.shareData.share2qqBlog;
  WeixinJSBridge.invoke("shareWeibo", {
    content: a.isios ? b.content + b.link : b.content,
    url: b.link
  }, function () { })
}

function sharetimeline() {
  var a = window.shareData.share2Friend;
  WeixinJSBridge.invoke("shareTimeline", {
    img_url: a.img,
    img_width: "640",
    img_height: "640",
    link: a.link,
    desc: " ",
    title: a.title
  }, function () { })
}

// get the client agent:ios, android
function getclientagent(){
  var a = window.navigator.userAgent;
  return this.isAndroid =
    a.match(/(Android)\s+([\d.]+)/) || a.match(/Silk-Accelerated/) ? !0 : !1,
  this.isiPad = a.match(/iPad/) ? !0 : !1,
  this.isiPod = a.match(/(iPod).*OS\s([\d_]+)/) ? !0 : !1,
  this.isiPhone = !this.isiPad && a.match(/(iPhone\sOS)\s([\d_]+)/) ? !0 : !1,
  this.isios = this.isiPhone || this.isiPad || this.isiPod, this
}

window.shareData && document.addEventListener("WeixinJSBridgeReady", wxshare, !1);
