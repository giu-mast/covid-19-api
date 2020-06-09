<form id="filters_pie" class="js-filters filters">
  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="api">
        Tipo API
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <select class="js-api">
          <option value="regions">Regioni</option>
          <option value="districts">Province</option>
        </select>
      </div>
    </div>
  </div>
  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="start_date_pie">
        Giorno
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <input 
            type="date" 
            id="start_date_pie" 
            name="start_date"
            value="2020-02-24"
            min="2020-02-24" max="2020-06-30">
      </div>
    </div>
  </div>

  <div class="form-row my-2 divs regions">
    <div class="col d-flex align-items-center">
      <label for="regions">
        Regioni
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <select class="js-choices" name="regions" multiple>
          <option value="13">Abruzzo</option>
          <option value="17">Basilicata</option>
          <option value="21">Bolzano</option>
          <option value="18">Calabria</option>
          <option value="15">Campania</option>
          <option value="08">Emilia-Romagna</option>
          <option value="06">Friuli Venezia Giulia</option>
          <option value="12">Lazio</option>
          <option value="07">Liguria</option>
          <option value="03">Lombardia</option>
          <option value="11">Marche</option>
          <option value="14">Molise</option>
          <option value="01">Piemonte</option>
          <option value="16">Puglia</option>
          <option value="20">Sardegna</option>
          <option value="19">Sicilia</option>
          <option value="09">Toscana</option>
          <option value="22">Trento</option>
          <option value="10">Umbria</option>
          <option value="02">Valle d'Aosta</option>
          <option value="05">Veneto</option>
        </select>
      </div>
    </div>
    <br>
    <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="regions">
        Metriche
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <label for="deceduti_pie">
          Deceduti
          <input id="deceduti_pie" type="radio" name="metric" value="total_deaths" />
        </label>

        <label for="totale_casi_pie">
          Totale casi
          <input class="totale_casi_pie" type="radio" name="metric" value="total_cases" checked="checked">
        </label>

        <label for="dimessi_guariti_pie">
          Dimessi guariti
          <input id="dimessi_guariti_pie" type="radio" name="metric" value="released_cured" />
        </label>

        <label for="tamponi_pie">
          Tamponi
          <input id="tamponi_pie" type="radio" name="metric" value="swabs" />
        </label>
      </div>
    </div>
  </div>
  </div>

  <div class="form-row my-2 divs districts" style="display:none">
    <div class="col d-flex align-items-center">
      <label for="districts">
        Province
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <select class="js-choices" name="districts" multiple>
          <option value="CH">Chieti</option>
          <option value="AQ">L'Aquila</option>
          <option value="PE">Pescara</option>
          <option value="TE">Teramo</option>          
          <option value="MT">Matera</option>
          <option value="PZ">Potenza</option>
          <option value="BZ">Bolzano</option>
          <option value="CZ">Catanzaro</option>
          <option value="CS">Cosenza</option>
          <option value="KR">Crotone</option>
          <option value="RC">Reggio di Calabria</option>
          <option value="VV">Vibo Valentia</option>
          <option value="AV">Avellino</option>
          <option value="BN">Benevento</option>
          <option value="CE">Caserta</option>
          <option value="NA">Napoli</option>
          <option value="SA">Salerno</option>
          <option value="BO">Bologna</option>
          <option value="FE">Ferrara</option>
          <option value="FC">Forlì Cesena</option>
          <option value="MO">Modena</option>
          <option value="PR">Parma</option>
          <option value="PC">Piacenza</option>
          <option value="RA">Ravenna</option>
          <option value="RE">Reggio nell'Emilia</option>
          <option value="RN">Rimini</option>
          <option value="GO">Gorizia</option>
          <option value="PN">Pordenone</option>
          <option value="TS">Trieste</option>
          <option value="UD">Udine</option>
          <option value="FR">Frosinone</option>
          <option value="LT">Latina</option>
          <option value="RI">Rieti</option>
          <option value="RM">Roma</option>
          <option value="VT">Viterbo</option>
          <option value="GE">Genova</option>
          <option value="IM">Imperia</option>
          <option value="SP">La Spezia</option>
          <option value="SV">Savona</option>
          <option value="BG">Bergamo</option>
          <option value="BS">Brescia</option>
          <option value="CO">Como</option>
          <option value="CR">Cremona</option>
          <option value="LC">Lecco</option>
          <option value="LO">Lodi</option>
          <option value="MN">Mantova</option>
          <option value="MI">Milano</option>
          <option value="MB">Monza della Brianza</option>
          <option value="PV">Pavia</option>
          <option value="SO">Sondrio</option>
          <option value="VA">Varese</option>
          <option value="AN">Ancona</option>
          <option value="AP">Ascoli Piceno</option>
          <option value="FM">Fermo</option>
          <option value="MC">Macerata</option>
          <option value="PU">Pesaro e Urbino</option>
          <option value="CB">Campobasso</option>
          <option value="IS">Isernia</option>
          <option value="AL">Alessandria</option>
          <option value="AT">Asti</option>
          <option value="BI">Biella</option>
          <option value="CN">Cuneo</option>
          <option value="NO">Novara</option>
          <option value="TO">Torino</option>
          <option value="VB">Verbano-Cusio-Ossola</option>
          <option value="VC">Vercelli</option>
          <option value="BA">Bari</option>
          <option value="BT">Barletta-Andria-Trani</option>
          <option value="BR">Brindisi</option>
          <option value="FG">Foggia</option>
          <option value="LE">Lecce</option>
          <option value="TA">Taranto</option>
          <option value="CA">Cagliari</option>
          <option value="NU">Nuoro</option>
          <option value="OR">Oristano</option>
          <option value="SS">Sassari</option>
          <option value="SU">Sud Sardegna</option>
          <option value="AG">Agrigento</option>       
          <option value="CL">Caltanissetta</option>
          <option value="CT">Catania</option>
          <option value="EN">Enna</option>
          <option value="ME">Messina</option>
          <option value="PA">Palermo</option>
          <option value="RG">Ragusa</option>
          <option value="SR">Siracusa</option>
          <option value="TP">Trapani</option>
          <option value="AR">Arezzo</option>
          <option value="FI">Firenze</option>
          <option value="GR">Grosseto</option>
          <option value="LI">Livorno</option>
          <option value="LU">Lucca</option>
          <option value="MS">Massa Carrara</option>
          <option value="PI">Pisa</option>
          <option value="PT">Pistoia</option>
          <option value="PO">Prato</option>
          <option value="SI">Siena</option>
          <option value="TN">Trento</option>
          <option value="PG">Perugia</option>
          <option value="TR">Terni</option>
          <option value="AO">Aosta</option>
          <option value="BL">Belluno</option>
          <option value="PD">Padova</option>
          <option value="RO">Rovigo</option>
          <option value="TV">Treviso</option>
          <option value="VE">Venezia</option>
          <option value="VR">Verona</option>
          <option value="VI">Vicenza</option>
        </select>
      </div>
    </div>
      <br>
    <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="regions">
        Metriche
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <label for="totale_casi_pie">
          Totale casi
          <input class="totale_casi_pie" type="radio" name="metric" value="total_cases" checked="checked">
        </label>
      </div>
    </div>
  </div>
  </div>

  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <div class="form-field">
        <button type="reset">Reset</button>
      </div>
      <div class="form-field">
        <button type="submit">Cerca</button>
      </div>
    </div>
  </div>
</form>