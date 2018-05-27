<?php
return [
  'error' => [
    'onlystudentaccess' => 'Registration API is allowed for student only',
    'couselistonlystudentaccess' => 'Inquiry Course API is allowed for student only',
  ] ,
  'regstatus' => [
    'pending' => 'Waiting for registration confirmation.',
    'failed' => 'Registration failed. Please contact registration office.',
    'registered' => 'Registration successful.',
    'reject' => 'Registration has been rejected. Please contact registration office.'
  ],
  'finstatus' => [
    'pending' => 'Waiting for payment period.',
    'await' => 'Waiting for payment.',
    'split' => 'Partial payment',
    'paid' => 'Paid',
    'overdue' => 'Payment overdue.',
    'reject' => 'Payment rejected.'
  ]
];
