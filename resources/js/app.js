//require('./bootstrap');

function getdata(method,data,succses = function(ans) {}) {

    let preloader = document.querySelector('.preloader')

    preloader.classList.add('active')

    let getdata = new XMLHttpRequest();

    getdata.open('POST','/api/' + method,true)
    getdata.setRequestHeader('Content-Type','application/json; charset=utf-8')
    getdata.setRequestHeader('X-CSRF-TOKEN',document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    getdata.send( JSON.stringify(data) )
    getdata.onreadystatechange = function() {
        if (getdata.readyState != 4) return;        
        ans = JSON.parse(getdata.responseText)
        console.log(ans)
        preloader.classList.remove('active')
        succses(ans);
    }
}

function showError(ans) {
    let afterwait = document.querySelector('.afterwait')

    afterwait.querySelector('.afterwait_subtitle > span').innerHTML = ans.mess;

    if (ans.mess != null) afterwait.querySelector('.afterwait_text').innerHTML = 'DEBUG: '+ ans.error;

    afterwait.classList.add('active')

    afterwait.querySelector('.afterwait__close').addEventListener('click',()=>{
        afterwait.classList.remove('active')
    })
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
            } else {
                showError(ans);
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
            } else {
                showError(ans);
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
