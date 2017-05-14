$('#myModal').on('shown.bs.modal', function (e) {
    //s
    $("#txtQuery").val("");
    $("#txtQuery").focus();
});


var notes_formated = [];

// Exibe o gráfico
window.onload = function () {
     
    // Itera o array e formata como integer 
    //$.each(notes, function(key, value){
      //  notes_formated.push({x: parseInt(value.x), y: parseInt(value.y)});
    //});
    
    var chart = new CanvasJS.Chart("chartContainer", {
        title: {
            text: "Notas"
        },
        axisX: {
            interval: 1
        },
        data: [{
		type: "column",
                dataPoints: notes
            }]
    });
    chart.render();
}