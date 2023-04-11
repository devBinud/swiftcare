
## install
> npm i jquery <br><br>
> npm i px-jquery-pagination

## css
> @import "~px-jquery-pagination/px-pagination.css";


## html
> \<div class="mypages"\>\</div\> <br>

## javascript - jquery
> require('px-jquery-pagination');

### init
> $(".mypages").pagination({ <br>
>            **currentpage:** 1,<br>
>            **totalPageCount:** 45,<br>
>            **maxBtnCount:** 5,<br>
>            **align:** 'center',<br> 
>            **nextPrevBtnShow:** true,<br>
>            **firstLastBtnShow:** true,<br>
>            **prevPageName:** '<',<br>
>            **nextPageName:** '>',<br>
>            **lastPageName:** '<<',<br>
>            **firstPageName:** '>>',<br>
>            **callback:** function(pagenumber){ console.log(pagenumber); }<br>
>        });<br>

### notes:
> **currentpage:** default clicked page number on initial load<br>
> **totalPageCount:** total number of pages<br>
> **maxBtnCount:** number of page buttons to display<br>
> **align:** button layout (left OR center OR right)<br>
> **nextPrevBtnShow:** display of previous and next buttons<br>
> **firstLastBtnShow:** display of last and first buttons<br>
> **callback:** callback function return the page number selected in the parameter<br>



### view:
![alt text](https://raw.githubusercontent.com/PiriAykut/px-jquery-pagination/master/screenshots/Screenshot_1.png)

<br>
<br>
