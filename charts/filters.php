<form class="js-filters filters">
  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="api">
        Tipo API
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <select id="api" class="js-api">
          <option value="regions">Regioni</option>
          <option value="districts">Province</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="start_date">
        Dal
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <input 
            type="date" 
            id="start_date" 
            name="start_date"
            value="2020-02-01"
            min="2020-02-01" max="2020-06-01">
      </div>
    </div>
  </div>

  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="end_date">
        Al
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <input 
            type="date" 
            id="end_date" 
            name="end_date"
            min="2020-02-01" max="2020-06-01">
      </div>
    </div>
  </div>

  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="regions">
        Regioni
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <select class="js-choices" name="regions" multiple>
          <option value="16">Puglia</option>
          <option value="3">Lombardia</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="regions">
        Province
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <select class="js-choices" name="districts" multiple>
          <option value="ba">Bari</option>
          <option value="le">Lecce</option>
          <option value="fg">Foggia</option>
          <option value="ta">Taranto</option>
          <option value="br">Brindisi</option>
          <option value="bt">Barletta-Andria-Trani</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-row my-2">
    <div class="col d-flex align-items-center">
      <label for="regions">
        Metriche
      </label>
    </div>
    <div class="col">
      <div class="form-field">
        <label for="deceduti">
          Deceduti
          <input id="deceduti" type="checkbox" name="metrics[]" value="deceduti" />
        </label>

        <label for="totale_casi">
          Totale casi
          <input id="totale_casi" type="checkbox" name="metrics[]" value="totale_casi" />
        </label>

        <label for="dimessi_guariti">
          Dimessi guariti
          <input id="dimessi_guariti" type="checkbox" name="metrics[]" value="dimessi_guariti" />
        </label>

        <label for="tamponi">
          Tamponi
          <input id="tamponi" type="checkbox" name="metrics[]" value="tamponi" />
        </label>
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