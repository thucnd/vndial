var bTable = {
    init: function(options, elem) {
        var self = this;
        // Mix in the passed in options with the default options
        this.options = $.extend({}, this.options, options);

        // Save the element reference, both as a jQuery
        // reference and a normal reference
        this.elem = elem;
        this.ajax = null;
        this.$elem = $(elem);
        this.bootstrapMajorVersion = 2;
        this.currentPage = 1;

        //init table
        this.initTableTags();

        //Genarate header table 
        this.displayHeaderTable();

        //Genarate footer table
        this.displayTableFooter();

        //Display data table
        this.displayDataTable();

        $(this.elem).children('#idTable').colResizable({liveDrag: true});

        // Fix header table
        //  this.fixheadertable();
        // $("table.table").floatThead();

        //Sorting click
        $(this.elem).on('click', '#idTable th', function(event) {
            event.preventDefault();
            self.resetSorting(this);
            self.displaySorting(this);
        });

        //Display row total
        $(this.elem).on('change','#tbPageShow', function(event) {
            event.preventDefault();
            //Reset page = 1
            self.currentPage = 1;
            self.displayDataTable();
        });
        return this;
    },
    options: {},
    displaySorting: function(thisCol) {
        var self = this;
        var sorting = $(thisCol).attr('class');

        if(typeof sorting == 'undefined') {
            return;
        }
        
        if (sorting === 'sorting') {
            $(thisCol).removeClass('sorting');
            $(thisCol).addClass('sorting_asc');

        } else if (sorting === 'sorting_asc') {
            $(thisCol).removeClass('sorting_asc');
            $(thisCol).addClass('sorting_desc');

        } else if (sorting === 'sorting_desc') {
            $(thisCol).removeClass('sorting_desc');
            $(thisCol).addClass('sorting_asc');
        }

        self.options["sortname"] = $(thisCol).attr('rel');
        self.options["sortorder"] = $(thisCol).attr('class');

        //Display table data
        self.displayDataTable();
    },
    resetSorting: function(thisCol) {
        var self = this;
        $(self.elem).children('#idTable').find("th").each(function() {
            var sorting = $(this).attr('class');
            if ((sorting === 'sorting_asc' || sorting === 'sorting_desc') && this != thisCol) {
                $(this).removeClass(sorting);
                $(this).addClass('sorting');
            }
        });
    },
    displayHeaderTable: function() {
        var self = this;
        var str = '<thead><tr>';
        var columns = self.options['colModel'];
       
        for (var i = 0; i < columns.length; i++) {
            var clsSorting = '';
            var relName = '';
            var align = ''
            var width = '';

            if (columns[i]['sortable']) {
                clsSorting = ' class="sorting" ';
            }

            //Display sort column
            if (columns[i]['name'] == self.options['sortname']) {
                clsSorting = ' class="sorting_' + self.options['sortorder'] + '" ';
            }

            //Display column name
            relName = ' rel="' + columns[i]['name'] + '" ';

            //Display aligin
            if (typeof columns[i]['align'] != 'undefined') {
                align = ' align="' + columns[i]['align'] + '" ';
            }

            //Display width
            if (typeof columns[i]['width'] != 'undefined') {
                width = ' style="width: ' + columns[i]['width'] + 'px;" ';
            }

            //Display sorting column
            str += '<th ' + clsSorting + relName + align + width + '><div class="tb-content-box">';
            str += columns[i]['display'];
            str += '</div></th>';
        }
        str += '</tr></thead>';
        $(self.elem).children('#idTable').append(str);
    },
    fixheadertable: function() {
//        var self = this;
//        var colratio;
//        var columns = self.options['colModel'];
//
//        for (var i = 0; i < columns.length; i++) {
//            if(i == 0) {
//                colratio = columns[i]['width'];
//            } else {
//                colratio = colratio + ',' + columns[i]['width'];
//            }
//        }
    },
    displayPagination: function(results) {
        var self = this;
        var str = '';
        var data = JSON.parse(results);

        if (this.bootstrapMajorVersion == 3) {
            str = '<ul id="tbPagination">';
            str += '</ul>';
        } else {
            str = '<div id="tbPagination"></div>';
        }

        $(self.elem).find('#tbPagination').remove();
        $(self.elem).children('#tbFooter').append(str);
        var rp = parseInt($('#tbPageShow').val());
        var numberPage = Math.ceil(parseInt(data['total']) / rp);
        var paginations = {
            bootstrapMajorVersion: self.bootstrapMajorVersion,
            currentPage: self.currentPage,
            totalPages: numberPage,
            alignment: "pagination-right",
            onPageClicked: function(e, originalEvent, type, page) {
                self.currentPage = page;
                self.displayDataTable();
            },
            itemTexts: function(type, page, current) {
                switch (type) {
                    case "first":
                        return "First";
                    case "prev":
                        return "Previous";
                    case "next":
                        return "Next";
                    case "last":
                        return "Last";
                    case "page":
                        return page;
                }
            }
        }
        $(self.elem).find('#tbPagination').bootstrapPaginator(paginations);
    },
    displayTableFooter: function() {
        var self = this;
        var strPage = '<div class="tb-box-left"><select id="tbPageShow" >';
        strPage += '<option value="10" selected="selected">10</option>';
        strPage += '<option value="25">25</option>';
        strPage += '<option value="50">50</option>';
        strPage += '<option value="100">100</option></select></div>';
        var str = '<div id="tbFooter">' + strPage + '</div>';
        $(self.elem).append(str);
    },
    displayDataTable: function() {
        var self = this;
        
        //Get table data
        var results = self.getData();        
        $(self.elem).children('#idTable').find('tbody').remove();
        var str = '<tbody>';
        var data = JSON.parse(results);
        var rows = data['rows'];
        var clsRow = '';
        var columns = self.options['colModel'];

        for (var i = 0; i < rows.length; i++) {
            clsRow = '';

            // Display Row color
            if (i % 2 != 0) {
                clsRow = 'class="success"';
            }
            str += '<tr ' + clsRow + '>';

            //Display data
            for (var j = 0; j < columns.length; j++) {
                str += '<td><div class="tb-content-box">';
                str += rows[i]['cell'][columns[j]['name']];
                str += '</div></td>';
            }
            str += '</tr>';
        }
        str += '</tbody>';
        $(self.elem).children('#idTable').append(str);

        //Display pagination
        self.displayPagination(results);
    },
    initTableTags: function() {
        var self = this;
        var clsTable = 'class="table theadTable ';
        if (typeof self.options['tblClass'] != 'undefined') {
            clsTable += self.options['tblClass'];
        }
        clsTable += '"';
        $(self.elem).empty();
        $(self.elem).append('<table  ' + clsTable + ' id="idTable"></table>');
    },
    ajaxSendTxt: function(objData, successCallback, errorCallback, url, method, async) {
        $.ajax({
            'url': url,
            'type': method,
            'async': async,
            'data': objData,
            'timeout': 120000,
            'error': errorCallback,
            'success': successCallback
        });
    },
    getData: function() {
        var self = this;
        var results = "";

        var successCallBack = function(json) {
            results = json;
        }

        var errorCallBack = function() {
            alert('failed');
        }

        var rp = parseInt($('#tbPageShow').val());
        var data = [{
                name: 'page',
                value: self.currentPage
            }, {
                name: 'rp',
                value: rp
            }, {
                name: 'sortname',
                value: self.options['sortname']
            }, {
                name: 'sortorder',
                value: self.options['sortorder'].replace('sorting_', '')
            }];
        this.ajaxSendTxt(data, successCallBack, errorCallBack, self.options['url'], "POST", false);

        return results;
    }
};

// Make sure Object.create is available in the browser (for our prototypal inheritance)
// Note this is not entirely equal to native Object.create, but compatible with our use-case
if (typeof Object.create !== 'function') {
    Object.create = function(o) {
        function F() {
        }// optionally move this outside the declaration and into a closure if you need more speed.
        F.prototype = o;
        return new F();
    };
}
;
(function($) {
    $.fn.btable = function(options) {
        if (this.length) {
            return this.each(function() {
                var plugin = Object.create(bTable);

                // Run the initialization function of plugin
                plugin.init(options, this);
            });
        }
    };
})(jQuery);
