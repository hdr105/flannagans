var AppCalendar = function() {

    return {
        //main function to initiate the module
        init: function(data) {

            this.initCalendar(data);
        },

        initCalendar: function(data) {

            if (!jQuery().fullCalendar) {
                return;
            }
            var eventsData = data;
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if (App.isRTL()) {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }
            } else {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }

            var initDrag = function(el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            };

            var addEvent = function(title) {
                title = title.length === 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            };
            var genEvents = function(){
                var events = [];
                for (var i = 0; i < eventsData.length; i++) {
                    var sD = (eventsData[i].start_date).split('-');
                    var eD = (eventsData[i].end_date).split('-');

                    var sT = (eventsData[i].start_time).split(':');
                    var eT = (eventsData[i].end_time).split(':');
                   
                    var anEvent = {};
                    anEvent['id'] = eventsData[i].id;
                    anEvent['title'] = eventsData[i].title;
                    anEvent['start'] = new Date(sD[0], (sD[1]-1), sD[2],sT[0],sT[1]);
                    anEvent['end'] = new Date(eD[0], (eD[1]-1), eD[2],eT[0],eT[1]);
                    anEvent['backgroundColor'] = eventsData[i].backgroundColor;
                    anEvent['allData'] = eventsData[i];

                    events.push(anEvent);

                }
                
                console.log(events);
                return events;
            }

            $('#external-events div.external-event').each(function() {
                initDrag($(this));
            });

            $('#event_add').unbind('click').click(function() {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");
            addEvent("My Event 1");
            addEvent("My Event 2");
            addEvent("My Event 3");
            addEvent("My Event 4");
            addEvent("My Event 5");
            addEvent("My Event 6");

            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/ 
                slotMinutes: 15,
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                dayClick: function(date, jsEvent, view) {
                    //alert('Clicked on: ' + date.format());
                    
                    var pre_selected = 'date_start='+date.format()+'|due_date='+date.format();
                    var jData = {};
                    jData['module_id'] = '25';
                    jData['module_key'] = 'id';
                    jData['module_value'] = 'subject';
                    jData['hidden_controll'] = '';
                    jData['visible_controll'] = '';
                    jData['pre_selected'] = pre_selected;
                    quickCreateModal(jData);

                },
                events: genEvents(),
                timeFormat: 'h(:mm)a ',
                columnFormat: {
                    month: 'ddd',
                    week: 'ddd d/M',
                    day: 'dddd d/M'
                },
                eventClick: function(calEvent, jsEvent, view) {
                    console.log(calEvent);
                    var jData = {};
                    jData['module_id'] = '25';
                    jData['module_key'] = 'id';
                    jData['module_value'] = 'subject';
                    jData['hidden_controll'] = '';
                    jData['visible_controll'] = '';
                    jData['key'] = '&key[calendar.id]='+calEvent.id;
                    quickCreateModal(jData);
                    
                }
            });

        }

    };

}();

