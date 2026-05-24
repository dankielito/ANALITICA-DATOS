$(function () {
    // Diccionario maestro con todas las entidades federativas
    const statsAbandono = {
        'mx-ag': { nombre: 'Aguascalientes', cant: '350,000', por: '12%' },
        'mx-bc': { nombre: 'Baja California', cant: '600,000', por: '15%' },
        'mx-bs': { nombre: 'Baja California Sur', cant: '150,000', por: '10%' },
        'mx-cm': { nombre: 'Campeche', cant: '200,000', por: '14%' },
        'mx-cs': { nombre: 'Chiapas', cant: '850,000', por: '22%' },
        'mx-ch': { nombre: 'Chihuahua', cant: '700,000', por: '18%' },
        'mx-co': { nombre: 'Coahuila', cant: '650,000', por: '16%' },
        'mx-cl': { nombre: 'Colima', cant: '180,000', por: '11%' },
        'mx-df': { nombre: 'Ciudad de México', cant: '1,200,000', por: '25%' },
        'mx-dg': { nombre: 'Durango', cant: '400,000', por: '14%' },
        'mx-gj': { nombre: 'Guanajuato', cant: '900,000', por: '19%' },
        'mx-gr': { nombre: 'Guerrero', cant: '750,000', por: '21%' },
        'mx-hg': { nombre: 'Hidalgo', cant: '500,000', por: '17%' },
        'mx-ja': { nombre: 'Jalisco', cant: '950,000', por: '20%' },
        'mx-me': { nombre: 'Estado de México', cant: '2,500,000', por: '30%' },
        'mx-mx': { nombre: 'Estado de México', cant: '2,500,000', por: '30%' }, // Clave adicional para cubrir el polígono
        'mx-mi': { nombre: 'Michoacán', cant: '800,000', por: '18%' },
        'mx-mo': { nombre: 'Morelos', cant: '350,000', por: '15%' },
        'mx-na': { nombre: 'Nayarit', cant: '250,000', por: '13%' },
        'mx-nl': { nombre: 'Nuevo León', cant: '800,000', por: '9%' },
        'mx-oa': { nombre: 'Oaxaca', cant: '950,000', por: '24%' },
        'mx-pu': { nombre: 'Puebla', cant: '1,100,000', por: '23%' },
        'mx-qt': { nombre: 'Querétaro', cant: '450,000', por: '12%' },
        'mx-qr': { nombre: 'Quintana Roo', cant: '300,000', por: '16%' },
        'mx-sl': { nombre: 'San Luis Potosí', cant: '550,000', por: '15%' },
        'mx-si': { nombre: 'Sinaloa', cant: '600,000', por: '14%' },
        'mx-so': { nombre: 'Sonora', cant: '650,000', por: '17%' },
        'mx-tb': { nombre: 'Tabasco', cant: '400,000', por: '19%' },
        'mx-tm': { nombre: 'Tamaulipas', cant: '700,000', por: '16%' },
        'mx-tl': { nombre: 'Tlaxcala', cant: '250,000', por: '14%' },
        'mx-ve': { nombre: 'Veracruz', cant: '1,300,000', por: '26%' },
        'mx-yu': { nombre: 'Yucatán', cant: '500,000', por: '13%' },
        'mx-za': { nombre: 'Zacatecas', cant: '350,000', por: '15%' }
    };

    function actualizarTarjeta() {
        const key = this['hc-key'];
        const info = statsAbandono[key];
        if (info) {
            $('#state-name').text(info.nombre);
            $('#pob-cantidad').text(info.cant);
            $('#pob-porcentaje').text(info.por);
            $('#bar-fill').css('width', info.por);
        }
    }

    Highcharts.mapChart('container-mapa-mx', {
        chart: { map: 'countries/mx/mx-all' },
        title: { text: '' },
        credits: { enabled: false },
        legend: { enabled: false },
        mapNavigation: { enabled: true, buttonOptions: { verticalAlign: 'bottom' } },
        
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                point: {
                    events: {
                        mouseOver: actualizarTarjeta,
                        click: actualizarTarjeta
                    }
                },
                states: {
                    hover: { color: '#01833d' },
                    select: { color: '#01833d' }
                }
            }
        },

        series: [{
            name: 'Situación de Calle',
            color: '#E6E7E8',
            dataLabels: {
                enabled: true,
                format: '{point.customName}',
                style: { fontSize: '9px', fontWeight: 'normal', textOutline: 'none', color: '#333333' }
            },
            data: Object.keys(statsAbandono).map(key => ({
                'hc-key': key,
                value: 1,
                customName: statsAbandono[key].nombre
            }))
        }]
    });
});