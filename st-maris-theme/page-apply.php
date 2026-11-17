<?php
/*
Template Name: Apply
*/
?>
<?php get_header(); ?>
<?php stmaris_hero( 'hero-apply', 'Admissions', 'Apply to ' . stmaris_info( 'name' ), 'Fill in the form below and our admissions office will get back to you.' ); ?>

<section class="section">
  <div class="container form-wrap">
    <?php stmaris_form_notice(); ?>
    <div class="card">
      <form class="apply-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="stmaris_apply">
        <?php wp_nonce_field( 'stmaris_apply' ); ?>
        <div class="hp-field" aria-hidden="true"><label>Leave this empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

        <fieldset>
          <legend>1. Student details</legend>
          <div class="form-row">
            <div class="field"><label for="first_name">First name <span class="req">*</span></label><input type="text" id="first_name" name="first_name" required></div>
            <div class="field"><label for="last_name">Last name <span class="req">*</span></label><input type="text" id="last_name" name="last_name" required></div>
          </div>
          <div class="form-row">
            <div class="field"><label for="dob">Date of birth <span class="req">*</span></label><input type="date" id="dob" name="dob" required></div>
            <div class="field"><label for="class">Class applying for <span class="req">*</span></label>
              <select id="class" name="class" required>
                <option value="">Select class</option>
                <option>Senior 1</option><option>Senior 2</option><option>Senior 3</option><option>Senior 4</option>
                <option>Senior 5 (A-Level)</option><option>Senior 6 (A-Level)</option>
              </select></div>
          </div>
          <div class="form-row">
            <div class="field"><label for="prev_school">Previous school <span class="req">*</span></label><input type="text" id="prev_school" name="prev_school" required></div>
            <div class="field"><label>Boarding or day <span class="req">*</span></label>
              <div class="choice"><label><input type="radio" name="boarding" value="Boarding" required> Boarding</label><label><input type="radio" name="boarding" value="Day"> Day</label></div></div>
          </div>
        </fieldset>

        <fieldset>
          <legend>2. Parent / guardian details</legend>
          <div class="form-row">
            <div class="field"><label for="guardian_name">Full name <span class="req">*</span></label><input type="text" id="guardian_name" name="guardian_name" required></div>
            <div class="field"><label for="relationship">Relationship to student <span class="req">*</span></label><input type="text" id="relationship" name="relationship" placeholder="e.g. Mother, Father, Guardian" required></div>
          </div>
          <div class="form-row">
            <div class="field"><label for="phone">Phone number <span class="req">*</span></label><input type="tel" id="phone" name="phone" placeholder="+256 7XX XXX XXX" required></div>
            <div class="field"><label for="email">Email address</label><input type="email" id="email" name="email"></div>
          </div>
          <div class="form-row">
            <div class="field"><label for="address">Home address <span class="req">*</span></label><input type="text" id="address" name="address" required></div>
          </div>
        </fieldset>

        <fieldset>
          <legend>3. Additional information</legend>
          <div class="field"><label for="notes">Anything else we should know?</label><textarea id="notes" name="notes" rows="4"></textarea></div>
        </fieldset>

        <p class="form-note">Please have the student's latest report card and birth certificate ready for the admissions interview.</p>
        <label class="check"><input type="checkbox" name="confirm" required> I confirm that the information given above is correct.</label>
        <button type="submit" class="btn">Submit application</button>
      </form>
    </div>
  </div>
</section>

<?php stmaris_editor_content(); ?>
<?php get_footer(); ?>
