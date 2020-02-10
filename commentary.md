#### ok ####
1) API Atbild uz HTTP pieprasījumu, 
#### ok ####
2) reģistrē PNG bildes ģenerēšanas pieteikumu un atgriež tā unikālo identifikātoru.
#### ok, informācija par datu nesakritību nav formāteta ####
3) Ja pieprasījuma kvadrāti pārklājas, robežojas ar citiem kvadrātiem vai bildes malām, kā arī, 
ja pieprasījumā tiek nosūtīti dati, kas kaut kādā veidā nav izpildāmi (negatīvas, nepareizas vērtības, 
nekorekta json struktūra utml.), tad jāatgriež kļūdu paziņojumi ar informāciju par datu nesakritību. 
#### inputa nav bijis derigs json vispar ####
#### nok ####
4) Pēc manuāla faila izsaukuma (aka CRON) uzģenerē vecāko bildes ģenerēšanas pieteikumu
#### nok, statusi ir piesaistiti #### 
5) Pēc pieprasījuma curl -X GET http://your-server/generation-status?id=auto-generated-identifier
atgriež šobrīdējo bildes ģenerēšanas stāvokli (pending, failed, in_progress, done)
