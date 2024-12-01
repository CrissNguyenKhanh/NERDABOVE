(function($) {
    "use strict";
    var HT = {}; 
    var _token = $('meta[name="csrf-token"]').attr('content'); // Sửa lỗi cú pháp

    HT.createMenuCatalogue = () => {
        $(document).on('submit', '.create-menu-catalouge', function(e) {
            e.preventDefault();
    
            let _form = $(this);
            let option = {
                'name': _form.find('input[name="name"]').val(),
                'keyword': _form.find('input[name="keyword"]').val(),
                '_token': _token
            };
    
            // Xóa thông báo lỗi cũ
            _form.find('.error').html('');
    
            $.ajax({
                url: 'ajax/menu/createCatalogue', 
                type: 'POST', 
                data: option,
                dataType: 'json', 
                success: function(res) {
                    console.log(res);
                    if (res.code == 0) {
                        console.log(res);
                        $('.form-error').removeClass('text-danger').addClass('text-success')
                            .html(res.message).show();
                            const menuCatalogueSelect = $('select[name=menu_catalogue_id]')
                            menuCatalogueSelect.append('<option value ="'+res.data.id+'">'+res.data.name+'</option>')
                    } else {
                       
                        $('.form-error').removeClass('text-success').addClass('text-danger')
                            .html(res.message).show();
                    }
                },
                beforeSend: function(){
                     _form.find('.error').html('');

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422 && jqXHR.responseJSON.errors) {
                        let errors = jqXHR.responseJSON.errors;
                 
                        for (let field in errors) {
                            let errorMessages = errors[field]; 
                            errorMessages.forEach(function(message) {
                                _form.find(`.error.${field}`).append(`<p>${message}</p>`);
                            });
                        }
                    } 
                }
            });
        });
    };
    
    HT.createMenuRow = () => {
        $(document).on('click', '.add-menu', function(e) {
            let _this = $(this);
            e.preventDefault();

            $('.menu-wrapper').find('.notification').hide();
    
       
            let newRow = HT.menuRowHtml();
            $('.menu-wrapper').append(newRow);
          
        });
    };
    
    HT.menuRowHtml = (option) => {
        let $row = $('<div>').addClass('row mb10 menu-item' + option.canonical);
        const columns = [
            { class: 'col-lg-4', name: 'menu[name][]', placeholder: 'Tên Menu' ,value: ((typeof(option)) != 'undefined') ? option.name : ''},
            { class: 'col-lg-4', name: 'menu[canonical][]', placeholder: 'Đường dẫn' ,value: ((typeof(option)) != 'undefined') ? option.canonical : '' },
            { class: 'col-lg-2', name: 'menu[order][]', placeholder: 'Vị trí',value:0 }
        ];
    
        columns.forEach(col => {
            let $col = $('<div>').addClass(col.class);
            let $input = $('<input>')
                .attr('type', 'text')
                .attr('value' ,col.value)
                .addClass('form-control'+ ((col.name =='menu[order][]') ? ' int text-right': ''))
                .attr('name', col.name)
                .attr('placeholder', col.placeholder); // Thêm placeholder
            $col.append($input);
            $row.append($col);
        });
    
        // Cột xóa
        let $removeCol = $('<div>').addClass('col-lg-2 text-center');
        let $removeBtn = $('<a>')
            .addClass('delete-menu btn btn-danger btn-sm')
            .attr('title', 'Xóa')
            .append($('<i>').addClass('fa fa-trash').attr('aria-hidden', true));
        $removeCol.append($removeBtn);
        $row.append($removeCol);
    
        return $row;
    };
    HT.deleteMenuRow = () => {
        $(document).on('click', '.delete-menu', function() {
            let $row = $(this).closest('.row');  // Find the row containing the delete button
            let $checkbox = $row.find('.choose-menu'); // Find the checkbox inside the row
            
            // Uncheck the checkbox explicitly (even if row is going to be removed)
            $checkbox.prop('checked', false);
            
            // Remove the row
            $row.remove();
            
            // Show the notification again if there are no rows left
            if ($('.menu-wrapper .row').length === 0) {
                $('.menu-wrapper').find('.notification').show();
            }
        });
    };
    
    
    HT.getMenu = () => {
        $(document).on('click', '.menu-model', function() {
            let _this = $(this);
            let option = {
                model: _this.attr('data-model')
            };
    
            // Clear menu list before making the request
            _this.parents('.panel-default').find('.menu-list').html('');
            let target =  _this.parents('.panel-default').find('.menu-list')  // Cập nhật phần tử với HTML đã tạo
           let menuRowClass = HT.checkMenuRowExist()
            HT.sendAjaxMenu(option,target,menuRowClass);


            
    
         
        });
    }
    HT.menuLink = (links) => {
        let nav = $('<nav>')
        if(links.length>3){
            let paginationUl = $('<ul>').addClass('pagination');  // Tạo phần tử <ul> cho pagination
       
            $.each(links, function(index, link) {
                let liClass = 'page-item';  // Mặc định class cho mỗi page item
                
                // Nếu đây là trang đang hoạt động
                if (link.active) {
                    liClass += ' active';
                } else if (!link.url) {
                    liClass += ' disabled';  // Nếu không có URL, thì disable item này
                }
                
                let li = $('<li>').addClass(liClass);  // Tạo phần tử <li>
                
                // Xử lý các nút "previous"
                if (link.label === 'pagination.previous') {
                    let span = $('<span>').addClass('page-link').attr('aria-hidden', true).html('&laquo;');  // Sử dụng ký hiệu "<<" cho "previous"
                    li.append(span);
                
                // Xử lý các nút "next"
                } else if (link.label === 'pagination.next') {
                    let span = $('<span>').addClass('page-link').attr('aria-hidden', true).html('&raquo;').attr('data-page' ,link.label);  // Sử dụng ký hiệu ">>" cho "next"
                    li.append(span);
                
                // Nếu là các trang thông thường
                } else if (link.url) {
                    let a = $('<a>').addClass('page-link').text(link.label).attr('href', link.url).attr('data-page' ,link.label);  // Tạo link cho mỗi trang
                    li.append(a);
                }
                
                paginationUl.append(li);  // Thêm <li> vào <ul>
            });
        
           // Bọc <ul> vào một <nav> tag
           // Trả về HTML của phần tử <nav>
        nav.append(paginationUl);
        }
        return nav[0].outerHTML; 
      
    };
    HT.sendAjaxMenu = (option,target,menuRowClass) =>{
        let _this =$(this);
        $.ajax({
            url: 'ajax/dashboard/getMenu', 
            type: 'GET', 
            data: option,
            dataType: 'json', 
            beforeSend: function() {
                // Optionally, show a loading state here
                _this.parents('.panel-default').find('.menu-list').html('Loading...');
            },
            success: function(res) {
                let html = '';
                if (res.data && res.data.length > 0) {
                    // Vòng lặp qua dữ liệu trả về và render menu
                    for (let i = 0; i < res.data.length; i++) {
                        html += HT.renderModelMenu(res.data[i],menuRowClass);
                    }
                    // Gọi HT.menuLink và lấy HTML của phần pagination
                    html += HT.menuLink(res.links);
                    target.html(html)
                } else {
                    html = '<p>No menus found</p>';
                }
            
                _this.parents('.panel-default').find('.menu-list').html(html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle any errors here (e.g., show an error message)
                _this.parents('.panel-default').find('.menu-list').html('<p>Error loading menu. Please try again.</p>');
                console.error('Request failed: ' + textStatus + ', ' + errorThrown);
            }
        });
    }
     HT.getPaginationMenu = () =>{
        $(document).on('click' ,'.page-link',function(e){
                  e.preventDefault()
                  let _this =$(this)
                  let option ={
                    model : _this.parents('.panel-collapse').attr('id'),
                    page :_this.text()
                  }
                  let target =  _this.parents('.menu-list')  // Cập nhật phần tử với HTML đã tạo
                 let menuRowClass = HT.checkMenuRowExist()
                  HT.sendAjaxMenu(option,target,menuRowClass)
        })

     }    

      HT.renderModelMenu = (object,menuRowClass) => {
        let html = '';
        html += `<div class="m-item">`;
        html += `  <div class="uk-flex uk-flex-middle">`;
        html += `    <input type="checkbox" ${(menuRowClass.includes(object.canonical) ? 'checked' : '')} class="m0 choose-menu" name="" value="${object.canonical}" id="${object.id}">`;
        html += `    <label for="object_${object.id}">${object.name}</label>`;
        html += `  </div>`;
        html += `</div>`;
        
        ;
        return html;  // Return the generated HTML
      };
      HT.checkMenuRowExist = () =>{
        let menuRowClass = $('.menu-item').map(function(){
            let allClasses = $(this).attr('class').split(' ').slice(3).join(' ')
            return allClasses;
        }).get()
        return menuRowClass;
      }
    HT.chooseMenu = () => {
        $(document).on('click', '.choose-menu', function() {
            let _this = $(this);
            let canonical = _this.val();
            let name = _this.siblings('label').text();
            
            // Check if the menu has already been added (avoid duplicates)
            if ($('.menu-wrapper').find(`input[value="${canonical}"]`).length > 0) {
                alert("This menu is already added.");
                return; // Exit the function if it's already in the list
            }
    
            let isChecked = _this.prop('checked'); // Store checkbox state (checked/unchecked)
    
            // Generate the row HTML for this menu item
            let $row = HT.menuRowHtml({
                name: name,
                canonical: canonical
            });
            console.log()
            
            if (isChecked) {
                // If checked, append the row to the menu
                $('.menu-wrapper').append($row).find('.notification').hide();
            } else {
                // If unchecked, remove the row with this specific canonical value
                $('.menu-wrapper').find(`.menu-item${canonical}`).remove();
            }
        });
    };
    
    HT.searchMenu = () => {
        let typingTimer;
        let doneTypingInterval = 1000; 
    
        $(document).on('keyup', '.search-menu', function (e) {
            let _this = $(this);
            let keyword = _this.val().trim(); 
            let option = {
                model: _this.parents('.panel-collapse').attr('id'),
                keyword : keyword
            }
          
                clearTimeout(typingTimer); 
                typingTimer = setTimeout(function () {
                    let menuRowClass = HT.checkMenuRowExist();
                    let target = _this.siblings('.menu-list')
                    HT.sendAjaxMenu(option,target,menuRowClass)
                  
                }, doneTypingInterval);
          
        });
    };
    $(document).ready(function() {
        HT.createMenuCatalogue();
        HT.createMenuRow();
        HT.deleteMenuRow();
        HT.getMenu();
        HT.chooseMenu();
        HT.getPaginationMenu();
        HT.searchMenu();
    });
})(jQuery);
