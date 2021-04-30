var json = '{"response":false,"message":"Title is required."}';
console.log(json);
var obj = JSON.parse(json);
console.log(obj.response);
console.log(obj["response"]);
console.log(JSON.stringify(json));


// Grid Parms
/*var GridParams={    "response":"true",
                    "title":['User id','User Name','Email','Mobile','Type','Time'],
                    "rows":[
                              ['USR24','student student','student@student.com','7878787878','user','2020-08-27 01:05:34'],
                              ['User id','User Name','Email','Mobile','Type','Time'],
                         ],  
                    "totalrows":99,         //For Pagination      
                    "currentpage":10,         //For Pagination      
                    "showdatalimit":10,           //For Pagination      
                    "option":{
                                   "isoption":true,
                                   "optiontitle":"Options",
                                   "optionfields":[ 'href','newtab'],                //href, newtab
                                   "optionToolTip":[ 'Edit','Delete'],
                                   "optionToolTipType":"fafa",                           //null, fafa
                              }
                              
                                  
                           
                    }*/



//'title'=['User id','User Name','Email','Mobile','Type','Time','Options'],'rows'=[['USR24','student student','student@student.com','7878787878','user','2020-08-27 01:05:34','<a href="useredit.php?userid=24"><button class="btn btn-success">EDIT</button></a>'],['User id','User Name','Email','Mobile','Type','Time','Options'],[],[]]
/* Params */
var GridOption = []; /* Option For Show dit Update delete Button */
// var GridParams=[];
var GridHtml = '';

function Grid(GridParams) {
    var titleHTML = '';
    var rowsHTML = '';
    var paginationHTML = '';
    var paginationSelectHTML = '';

    if (GridParams['response']) {

        /* Pagination */
        if (GridParams['pagination']['ispagination']) {
            var totalPages = Math.ceil(GridParams['pagination']['totalrows'] / GridParams['pagination']['showdatalimit']);
            var currentPage = GridParams['pagination']['currentpage'];
            if (totalPages > 1) {

                /* First Button */
                if (currentPage != 1) {
                    paginationHTML += `<button class='btn m-1 pagenumber' data-pagenumber="1">First</button>`;
                }
                /*Prev Button */
                if (currentPage >= 2) {
                    paginationHTML += `<button class='btn m-1 pagenumber' data-pagenumber="` + (currentPage - 1) + `" >Prev</button>`;
                }

                /*Middle Page Buttons */
                if (currentPage > 2) {
                    paginationPage = currentPage - 2
                } else if (currentPage == 2) {
                    paginationPage = currentPage - 1
                } else {
                    paginationPage = currentPage;
                }
                var count = 0;
                for (i = paginationPage; i <= totalPages; i++) {
                    if (count < 5) {
                        paginationHTML += `<button class='btn m-1 pagenumber ${currentPage == i ? 'btn-success' : ''}' data-pagenumber="` + i + `" onclick="PaginationClick(` + i + `)">` + i + `</button>`;
                    }
                    count++;
                }

                /*Next/Last  Button */
                if (currentPage != totalPages) {
                    paginationHTML += `<button class='btn m-1 pagenumber' data-pagenumber="` + (currentPage + 1) + `" >Next</button>
                                             <button class='btn m-1 pagenumber'data-pagenumber="` + totalPages + `" >Last</button>`;
                }
            }
        }

        /* Select Option */
        if (GridParams['pagination']['isselect']) {
            if (GridParams['pagination']['selectoption']) {
                paginationSelectHTML += `<select id="gridselect" name="cacheMode" class="select2 w-100 selectnumber">`;
                GridParams['pagination']['selectoption'].forEach(function(value, index) {
                    paginationSelectHTML += ` <option value="` + value + `" ${GridParams['pagination']['showdatalimit'] == value ? 'selected' : ''}   >` + value + `</option>>`;
                })
                paginationSelectHTML += `</select>`;
            }

        }


        /* Title */
        if (GridParams['title']) {
            titleHTML += `<tr>`;
            $.each(GridParams['title'], function(key, value) {
                    titleHTML += `<th>` + value + `</th>`
                })
                /* Option Columns  */
            if (GridParams['option']['isoption']) {
                titleHTML += `<th class="text-center">` + GridParams['option']['optiontitle'] + `</th>`
            }
            titleHTML += `</tr>`;
        }

        /* Rows */
        if (GridParams['rows']) {
            /* Multipal Data */
            GridParams['rows'].forEach(rowelement => {
                rowsHTML += `<tr>`
                    /** Columns **/
                $.each(rowelement, function(key, value) {
                    if (key in GridParams['title']) {
                        rowsHTML += `<td>` + value + `</td>`
                    }
                });
                /* Option Columns  */
                if (GridParams['option']['isoption']) {
                    rowsHTML += `<td class="text-center">`
                    GridParams['option']['optionfields'].forEach(function(element, index) {
                        var optionkey = GridParams['option']['optionKey'][index];
                        var optionurl = GridParams['option']['optionLink'][index];
                        switch (element) {
                            case "href":
                                rowsHTML += `<a href="` + optionurl + rowelement[optionkey] + `"><button class="btn btn-sm ` + GridParams['option']['optionAdditionalClass'][index] + `" data-key="` + rowelement[optionkey] + `" data-toggle="tooltip" data-placement="top" title="` + GridParams['option']['optionToolTip'][index] + `">${GridParams['option']['isFaFa'] ? '<i class="' + GridParams['option']['optionFaFa'][index] + '"></i>' : GridParams['option']['optionToolTip'][index]}</button></a>`
                                break;
                            case "newtab":
                                // rowsHTML+=`<a href="`+optionurl+rowelement[optionkey]+`" target="_blank"><button class="btn">`+GridParams['option']['optionToolTip'][index]+`</button></a>` 
                                rowsHTML += `<a href="` + optionurl + rowelement[optionkey] + `"  target="_blank" ><button class="btn btn-sm ` + GridParams['option']['optionAdditionalClass'][index] + `" data-key="` + rowelement[optionkey] + `" data-toggle="tooltip" data-placement="top" title="` + GridParams['option']['optionToolTip'][index] + `">${GridParams['option']['isFaFa'] ? '<i class="' + GridParams['option']['optionFaFa'][index] + '"></i>' : GridParams['option']['optionToolTip'][index]}</button></a>`
                                break;
                            case "#":
                                rowsHTML += `<button class="btn btn-sm ` + GridParams['option']['optionAdditionalClass'][index] + `" data-key="` + rowelement[optionkey] + `" data-toggle="tooltip" data-placement="top" title="` + GridParams['option']['optionToolTip'][index] + `">${GridParams['option']['isFaFa'] ? '<i class="' + GridParams['option']['optionFaFa'][index] + '"></i>' : GridParams['option']['optionToolTip'][index]}</button>`
                                break;
                                // case "href":
                                //      rowsHTML+=`<a href="useredit.php?userid=24"><button class="btn">EDIT</button></a>` 
                                //      break;
                            default:
                                break;
                        }
                    });
                    rowsHTML += `</td>`
                }

                rowsHTML += `</tr>`;
            });
        }
    }

    GridHtml = `<div id="">
                    <div class="row">
                         <div class="col-md-3">
                              Total Count: ` + GridParams['pagination']['totalrows'] + `
                         </div>
                         <div class="col-md-6">
                              ` + paginationHTML + `
                         </div>
                         <div class="col-md-3">
                              ` + paginationSelectHTML + `
                         </div>
                         <div class="col-md-12">
                              
                         </div>
                    </div> 
                    <div class="mt-2 table-responsive-md table-responsive-lg table-responsive-sm text-nowrap" style="width:100%; ">
                        <table class="table table-bordered">  
                            <thead  class="thead-dark">
                                ` + titleHTML + `
                            </thead>
                            <tbody>
                                ` + rowsHTML + ` 
                            </tbody>
                        </table>
                    </div>
               </div>`;
    $('#gridselect').select2();
    return GridHtml;
}