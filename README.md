###Created to realise below placed points###



Izveidot php API, kas spēj ģenerēt PNG bildes ar aizpildītiem taisnstūriem
Detalizēta specifikācija

1) API Atbild uz HTTP pieprasījumu, reģistrē PNG bildes ģenerēšanas pieteikumu un atgriež tā unikālo identifikātoru.
Ja pieprasījuma kvadrāti pārklājas, robežojas ar citiem kvadrātiem vai bildes malām, kā arī, ja pieprasījumā tiek nosūtīti dati, kas kaut kādā veidā nav izpildāmi (negatīvas, nepareizas vērtības, nekorekta json struktūra utml.), tad jāatgriež kļūdu paziņojumi ar informāciju par datu nesakritību.
Pieprasījuma piemērs

curl -X POST http://your-server/generate-rectangles -d '
{
    width: 1024, // jebkāds pozitīvs skaitlis robežās [640, 1920]
    height: 1024, // jebkāds pozitīvs skaitlis robežās [480, 1080]
    color: '#fff', // jebkāds HEX krāsu kods
    rectangles: [
        { 
            id: 'my-id' //jebkāds teksts vai skaitlis, kas nepārsniedz 255 simbolus un ir unikāls visa rectangles masīva ietvaros
            x: 10, // jebkāds pozitīvs skaitlis
            y: 10, // jebkāds pozitīvs skaitlis
            height: 100, // jebkāds pozitīvs skaitlis
            width: 200, // jebkāds pozitīvs skaitlis
            color: '#000' // jebkāds HEX krāsu kods
        },
        ...
    ]
}'

Veiksmīgas apstrādes atbildes piemērs:
{
    success: true,
    id: auto-generated-identifier
}
Neveiksmīgas atbildes piemērs (kļūdu paziņojumu struktūra ir atvērta interpretācijai):
{
    success: false,
    errors: {
        'rectangles_overlap': ['rectangle_id', ...],
        'rectangles_out_of_bounds': ['rectangle_id'],
        'image_doesnt_fit_constraints': ['width'],
        'malformatted_json': []
    }
}

2) Pēc manuāla faila izsaukuma (aka CRON) uzģenerē vecāko bildes ģenerēšanas pieteikumu
3) Pēc pieprasījuma curl -X GET http://your-server/generation-status?id=auto-generated-identifier
atgriež šobrīdējo bildes ģenerēšanas stāvokli (pending, failed, in_progress, done)
Piemērs pending: 
{
    status: 'pending'
    queue_length: 5 // bilžu skaits, kas ir priekšā
}
Piemērs failed:  
{
    status: 'failed'
    reason: 'item_not_found' //notikusi kāda kļūme
}
Piemērs in_progress:  
{
    status: 'in_progress'
}
Piemērs done:  
{
    status: 'done'
    url: 'http://your-server/generated-image-location //bildes url, kurā to var saņemt kā (Content-Type: image/png)
}
