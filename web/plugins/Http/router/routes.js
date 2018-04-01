    var Ziggy = {
        namedRoutes: {"api.":{"uri":"api\/video\/{video}\/comments","methods":["GET","HEAD"],"domain":null},"api.channel.metrics":{"uri":"api\/channel\/{channel}\/metrics","methods":["GET","HEAD"],"domain":null},"api.channel.comments.bots":{"uri":"api\/channel\/{channel}\/comments\/bots","methods":["GET","HEAD"],"domain":null},"api.channel.comments":{"uri":"api\/channel\/{channel}\/comments","methods":["GET","HEAD"],"domain":null},"api.channels.bots":{"uri":"api\/channel\/bots","methods":["GET","HEAD"],"domain":null},"api.channels.followed":{"uri":"api\/channels\/followed","methods":["GET","HEAD"],"domain":null},"api.channel.videos":{"uri":"api\/channel\/{channel}\/videos","methods":["GET","HEAD"],"domain":null},"api.channel.show":{"uri":"api\/channel\/{channel}","methods":["GET","HEAD"],"domain":null},"api.channel.check":{"uri":"api\/channel\/check","methods":["POST"],"domain":null},"api.channel.report":{"uri":"api\/channel\/report","methods":["POST"],"domain":null},"api.channel.moderate":{"uri":"api\/channel\/{channel}\/moderate","methods":["POST"],"domain":null},"api.videos":{"uri":"api\/videos","methods":["GET","HEAD"],"domain":null},"api.video.show":{"uri":"api\/video\/{video}","methods":["GET","HEAD"],"domain":null},"home":{"uri":"\/","methods":["GET","HEAD"],"domain":null},"channel.created.date":{"uri":"channels\/created\/{date}","methods":["GET","HEAD"],"domain":null},"channel.bots.date":{"uri":"bots\/created\/{date}","methods":["GET","HEAD"],"domain":null},"channel.bots":{"uri":"bots\/grouped-by-date","methods":["GET","HEAD"],"domain":null},"channel.moderation":{"uri":"channels\/moderate","methods":["GET","HEAD"],"domain":null},"channel.show":{"uri":"channel\/{channel}","methods":["GET","HEAD"],"domain":null},"tag.show":{"uri":"tag\/{tag}","methods":["GET","HEAD"],"domain":null},"video.show":{"uri":"video\/{video}","methods":["GET","HEAD"],"domain":null},"comments.spam":{"uri":"comments\/spam","methods":["GET","HEAD"],"domain":null},"comment.show":{"uri":"comment\/{comment}","methods":["GET","HEAD"],"domain":null}},
        baseUrl: 'http://localhost/',
        baseProtocol: 'http',
        baseDomain: 'localhost',
        basePort: false,
        defaultParameters: []
    };

    export {
        Ziggy
    }
