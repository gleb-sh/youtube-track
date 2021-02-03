document.querySelector('form').addEventListener('submit',(e)=>{
    e.preventDefault();
    e.stopImmediatePropagation()
    e.stopPropagation()

    let data = {}
    let stop

    e.target.querySelectorAll('input').forEach(input => {
        if (input.value.length >= 3) {
            data[input.name] = input.value
        } else if (input.type == "hidden" && input.value == "") {
            //
        } else {
            stop = true
            stopform(e.target)
            return;
        }
    });

    if (!stop) {
        var getdata = new XMLHttpRequest();
        getdata.open('POST','/api/login',true)
        getdata.setRequestHeader('Content-Type','application/json; charset=utf-8')
        getdata.setRequestHeader('X-CSRF-TOKEN',document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
        getdata.send( JSON.stringify(data) )
        getdata.onreadystatechange = function() {
            if (getdata.readyState != 4) return;
            ans = JSON.parse(getdata.responseText)
            console.log(ans)
            if (ans.status === 1) window.location = '/welcome'
        }
    } else {
        stopform(e.target)
    }

    return false;
})

function stopform(form) {
    form.querySelectorAll('input').forEach(el=>{
        el.classList.add('error')
    })
}