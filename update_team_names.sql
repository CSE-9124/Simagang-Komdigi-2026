-- Update team names for existing interns
-- Change TIM Media to TIM Media (DiaPus)
UPDATE interns 
SET team = 'TIM Media (DiaPus)', updated_at = NOW()
WHERE team = 'TIM Media';

-- Change TIM Tata Usaha to TIM Tata Usaha (Umum)
UPDATE interns 
SET team = 'TIM Tata Usaha (Umum)', updated_at = NOW()
WHERE team = 'TIM Tata Usaha';

