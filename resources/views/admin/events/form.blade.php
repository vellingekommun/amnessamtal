                    <div class="form-group">
                        <label for="name">Titel</label>
                        <input type="text" name="title" title="Titel" placeholder="Titel" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $title ?? old('title') }}" required />

                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="starts_at">Tillfället börjar</label>
                                <input type="datetime-local" name="starts_at" class="form-control {{ $errors->has('starts_at') ? ' is-invalid' : '' }}" value="{{ $dates['starts_at'] }}" required {{ $readonly }} />

                                @if ($errors->has('starts_at'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('starts_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="ends_at">Tillfället slutar</label>
                                <input type="datetime-local" name="ends_at" class="form-control {{ $errors->has('ends_at') ? ' is-invalid' : '' }}" value="{{ $dates['ends_at'] }}" required {{ $readonly }} />

                                @if ($errors->has('ends_at'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ends_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="session_length">Längd på mötestiden i minuter (0-59)</label>
                                <input type="number" name="session_length" class="form-control {{ $errors->has('session_length') ? ' is-invalid' : '' }}" value="{{ $session_length }}" required {{ $readonly }} />

                                @if ($errors->has('session_length'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('session_length') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="break_length">Längd på pauser i minuter (0-59)</label>
                                <input type="number" name="break_length" class="form-control {{ $errors->has('break_length') ? ' is-invalid' : '' }}" value="{{ $break_length }}" required {{ $readonly }} />

                                @if ($errors->has('break_length'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('break_length') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="booking_starts_at">Bokningen öppnar</label>
                                <input type="datetime-local" name="booking_starts_at" class="form-control {{ $errors->has('booking_starts_at') ? ' is-invalid' : '' }}" value="{{ $dates['booking_starts_at'] }}" required />

                                @if ($errors->has('booking_starts_at'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('booking_starts_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="booking_ends_at">Bokningen stänger</label>
                                <input type="datetime-local" name="booking_ends_at" class="form-control {{ $errors->has('booking_ends_at') ? ' is-invalid' : '' }}" value="{{ $dates['booking_ends_at'] }}" required />

                                @if ($errors->has('booking_ends_at'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('booking_ends_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
              
                    <div class="form-group">
                        <label for="booking_information">Bokningsinformation till besökaren (HTML)</label>
                        <textarea type="text" name="booking_information" class="form-control {{ $errors->has('booking_information') ? ' is-invalid' : '' }}" required >{{ $booking_information }}</textarea>

                        @if ($errors->has('booking_information'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('booking_information') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">

                        <label for="email_confirmation">Bekräftelsemail till besökaren</label>
                        <textarea name="email_confirmation" class="form-control {{ $errors->has('email_confirmation') ? ' is-invalid' : '' }}" required >{{ $email_confirmation }}</textarea>

                        @if ($errors->has('email_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email_reminder">Påminnelsemail till besökaren</label>
                        <textarea type="text" name="email_reminder" class="form-control {{ $errors->has('email_reminder') ? ' is-invalid' : '' }}" required >{{ $email_reminder }}</textarea>

                        @if ($errors->has('email_reminder'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email_reminder') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="sms_reminder">Påminnelse-SMS till besökaren</label>
                        <textarea type="text" name="sms_reminder" class="form-control {{ $errors->has('sms_reminder') ? ' is-invalid' : '' }}" aria-describedby="passwordHelpInline" required >{{ $sms_reminder }}</textarea>
                        <small id="passwordHelpInline" class="text-muted">
                          Använd {datum} för att infoga datumet för ämnessamtalet och {länk} för att infoga en länk till bokade tider.
                        </small>

                        @if ($errors->has('sms_reminder'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sms_reminder') }}</strong>
                            </span>
                        @endif
                    </div> 