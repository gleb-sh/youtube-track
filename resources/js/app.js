//require('./bootstrap');

function getdata(method,data,succses = function(ans) {}) {
    let getdata = new XMLHttpRequest();

    getdata.open('POST','/api/' + method,true)
    getdata.setRequestHeader('Content-Type','application/json; charset=utf-8')
    getdata.setRequestHeader('X-CSRF-TOKEN',document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    getdata.send( JSON.stringify(data) )
    getdata.onreadystatechange = function() {
        if (getdata.readyState != 4) return;
        ans = JSON.parse(getdata.responseText)
        console.log(ans)
        succses(ans);
    }
}

document.querySelectorAll('form').forEach(form=>{

    form.addEventListener('submit',(e)=>{
        e.preventDefault()
        e.stopPropagation()

        let method = form.dataset.method
        let data = {}

        form.querySelectorAll('input').forEach(input=>{
            data[input.name] = input.value
        })

        getdata(method,data,(ans)=>{
            if (ans.status === 1) {
                if (ans.mess === 'reload') {
                    window.location.reload()
                }
                if (ans.mess === 'link') {
                    window.location = ans.data.link
                }
            }
        })

        return false;
    })
})

document.querySelectorAll('div[data-click]').forEach(div=>{
    
    div.addEventListener('click',(e)=>{

        let method = div.dataset.click
        let data = {}
        data[div.dataset.name] = div.dataset.content

        getdata(method,data,(ans)=>{
            if (ans.status === 1) {
                if (ans.mess === 'reload') {
                    window.location.reload()
                }
                if (ans.mess === 'link') {
                    window.location = ans.data.link
                }
            }
        })

        return false;

    })
})

document.querySelectorAll('*[data-href]').forEach(div=>{
    div.addEventListener('click',()=>{
        window.location = div.dataset.href
    })
})
