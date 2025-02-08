const tocContainer = document.querySelector('#toc');
if(tocContainer){
    const headings = document.querySelectorAll('.entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6');
    if (headings.length > 1)
    {
        const startingLevel = headings[0].tagName[1];
        const toc = document.createElement('ul');
        const prevLevels = [0, 0, 0, 0, 0, 0];
        for (let i = 0; i < headings.length; i++) {
            const heading = headings[i];
            const level = parseInt(heading.tagName[1]);
            prevLevels[level - 1]++;
            for (let j = level; j < prevLevels.length; j++) {
                prevLevels[j] = 0;
            }
            const sectionNumber = prevLevels.slice(startingLevel - 1, level).join('.').replace(/\.0/g, "");
            const newHeadingId = `${heading.textContent.toLowerCase().replace(/ /g, '-')}`;
            heading.id = newHeadingId;
            const anchor = document.createElement('a');
            const url = new URL(window.location.href);
            const pathandQuery = url.pathname + url.search;
            anchor.setAttribute('href', `${pathandQuery}#${newHeadingId}`);
            anchor.textContent = heading.textContent;

            anchor.addEventListener('click', (event) => {
                event.preventDefault();
                const href = event.target.getAttribute('href');
                const targetId = href.replace(pathandQuery, '').slice(1);
                const targetElement = document.getElementById(targetId);
                targetElement.scrollIntoView({ behavior: 'smooth' });
                history.pushState(null, null, href);
            })
            const listItem = document.createElement('li');
            listItem.appendChild(anchor);

            const className = `toc-${heading.tagName.toLowerCase()}`;
            listItem.classList.add('toc-item');
            listItem.classList.add(className);
            toc.appendChild(listItem);
        }
        if(tocContainer){
            tocContainer.innerHTML = '';
            tocContainer.appendChild(toc);
        }
    }else{
        const toc_wrap = document.getElementById('toc-wrap');
        if(toc_wrap){
            toc_wrap.style.display = 'none';
        }
    }
    window.addEventListener('scroll', function() {
        let scroll = window.scrollY;
        let height = window.innerHeight;
        let offset = 200;

        headings.forEach(function (heading, index) {
            let i = index + 1;
            let target = document.querySelector('#toc li:nth-of-type(' + i + ') > a');
            let pos = heading.getBoundingClientRect().top + scroll;
            if (!target) return;

            if (scroll > pos - height + offset) {
                if (headings[index + 1] !== undefined) {
                    let next_pos = headings[index + 1].getBoundingClientRect().top + scroll;
                    if (scroll > next_pos - height + offset) {
                        target.classList.remove('toc-active');
                    } else if (i === 1 && typeof tocContainer !== 'undefined' && tocContainer.classList.contains('active') === false) {
                        target.classList.add('toc-active');
                        tocContainer.classList.add('active');
                    } else {
                        target.classList.add('toc-active');
                    }
                } else {
                    target.classList.add('toc-active');
                }
            } else {
                target.classList.remove('toc-active');
                if (i === 1 && typeof tocContainer !== 'undefined' && tocContainer.classList.contains('active')) {
                    tocContainer.classList.remove('active');
                }
            }
        })
    })
}

function copyToClipboard(e, btn) {
    e.preventDefault();
    const textToCopy = btn.dataset.content;
    if(textToCopy){
        navigator.clipboard.writeText(textToCopy).then(function() {
            btn.innerText = 'Đã copy';
        }).catch(function(error) {
            return error;
        });
    }
}
document.addEventListener('DOMContentLoaded', function (){
   const btnCopy = document.querySelectorAll('.btn-copy');
   if (btnCopy && btnCopy.length){
       Array.from(btnCopy).forEach(function (btn){
           btn.addEventListener('click', function (e){
               copyToClipboard(e, btn);
           });
       });
   }
});
