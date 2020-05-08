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
            min="2020-01-01" max="2020-06-01">
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
            min="2020-01-01" max="2020-06-01">
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
          <option value="puglia">Puglia</option>
          <option value="lombardia">Lombardia</option>
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
      <div class="form-field">
        <button type="reset">Reset</button>
      </div>
      <div class="form-field">
        <button type="submit">Cerca</button>
      </div>
    </div>
  </div>
</form>