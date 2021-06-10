<?php

namespace Drupal\verathon_bflex_calculator;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Calculator service.
 */
class Calculator
{

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  private const CURRENT_SU_BLEX_USAGE = 0;  // maps to C11
  private const CROSS_CONTAMINATION_FACTOR_A = .034; // maps to first factor in C28
  private const CROSS_CONTAMINATION_FACTOR_B = .2125; // maps to second factor in C28
  private const COST_PER_INFECTION = 28383; // maps to C30

  protected $reprocessingCostsLow;
  protected $reprocessingCostsAverage;
  protected $reprocessingCostsHigh;
  protected $totalProcedures; // maps to C4
  protected $singleUseProcedures; // maps to C5
  protected $proceduresRequiringReusable; // maps to C6
  protected $bflexBroncoscopePrice; // maps to C7
  protected $currentReusableQuantity; // maps to C14
  protected $currentAnnualServicePer; // maps to C15
  protected $reprocessingCalcMethod; // maps to C19
  protected $currentAnnualOopRepairAllFactor; // Maps factor in C16
  protected $reducingReusableScopes; // // maps to F14

  /**
   * Constructs a Calculator object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory)
  {
    $this->configFactory = $config_factory;

    $config = $this->configFactory->getEditable('verathon_bflex_calculator.settings')->get();
    $this->reprocessingCostsLow = [
      'ppe_personal' => (!empty($config['ppe_personal_factor_low']) &&  is_numeric($config['ppe_personal_factor_low'])) ? $config['ppe_personal_factor_low'] : 5.06, // maps to C20
      'bedside_preclean' => (!empty($config['bedside_preclean_factor_low']) && is_numeric($config['bedside_preclean_factor_low'])) ? $config['bedside_preclean_factor_low'] : 4.45, // maps to C21
      'leak_testing' => (!empty($config['leak_testing_factor_low']) && is_numeric($config['leak_testing_factor_low'])) ? $config['leak_testing_factor_low'] : 2.27, // maps to C22,
      'manual_cleaning' => (!empty($config['manual_cleaning_factor_low']) && is_numeric($config['manual_cleaning_factor_low'])) ? $config['manual_cleaning_factor_low'] : 11.12, // maps to C23
      'visual_inspection' => (!empty($config['visual_inspection_factor_low']) && is_numeric($config['visual_inspection_factor_low'])) ? $config['visual_inspection_factor_low'] : 14.62, // maps to C24
      'hld_in_aer' => (!empty($config['hld_in_aer_factor_low']) && is_numeric($config['hld_in_aer_factor_low'])) ? $config['hld_in_aer_factor_low'] : 10.74, // maps to C25
      'drying_storage' => (!empty($config['drying_storage_factor_low']) && is_numeric($config['drying_storage_factor_low'])) ? $config['drying_storage_factor_low'] : 1.88 // maps to C26
    ];

    $this->reprocessingCostsAverage = [
      'ppe_personal' => (!empty($config['ppe_personal_factor_average']) && is_numeric($config['ppe_personal_factor_average'])) ? $config['ppe_personal_factor_average'] : 11.42, // maps to C20
      'bedside_preclean' => (!empty($config['bedside_preclean_factor_average']) && is_numeric($config['bedside_preclean_factor_average'])) ? $config['bedside_preclean_factor_average'] : 11.80, // maps to C21
      'leak_testing' => (!empty($config['leak_testing_factor_average']) && is_numeric($config['leak_testing_factor_average'])) ? $config['leak_testing_factor_average'] : 3.78, // maps to C22,
      'manual_cleaning' => (!empty($config['manual_cleaning_factor_average']) && is_numeric($config['manual_cleaning_factor_average'])) ? $config['manual_cleaning_factor_average'] : 24.12, // maps to C23
      'visual_inspection' => (!empty($config['visual_inspection_factor_average']) && is_numeric($config['visual_inspection_factor_average'])) ? $config['visual_inspection_factor_average'] : 32.16, // maps to C24
      'hld_in_aer' => (!empty($config['hld_in_aer_factor_average']) && is_numeric($config['hld_in_aer_factor_average'])) ? $config['hld_in_aer_factor_average'] : 13.98, // maps to C25
      'drying_storage' => (!empty($config['drying_storage_factor_average']) && is_numeric($config['drying_storage_factor_average'])) ? $config['drying_storage_factor_average'] : 4.17 // maps to C26
    ];

    $this->reprocessingCostsHigh = [
      'ppe_personal' => (!empty($config['ppe_personal_factor_high']) && is_numeric($config['ppe_personal_factor_high'])) ? $config['ppe_personal_factor_high'] : 17.78, // maps to C20
      'bedside_preclean' => (!empty($config['bedside_preclean_factor_high']) && is_numeric($config['bedside_preclean_factor_high'])) ? $config['bedside_preclean_factor_high'] : 19.14, // maps to C21
      'leak_testing' => (!empty($config['leak_testing_factor_high']) && is_numeric($config['leak_testing_factor_high'])) ? $config['leak_testing_factor_high'] : 5.28, // maps to C22,
      'manual_cleaning' => (!empty($config['manual_cleaning_factor_high']) && is_numeric($config['manual_cleaning_factor_high'])) ? $config['manual_cleaning_factor_high'] : 37.11, // maps to C23
      'visual_inspection' => (!empty($config['visual_inspection_factor_high']) && is_numeric($config['visual_inspection_factor_high'])) ? $config['visual_inspection_factor_high'] : 48.69, // maps to C24
      'hld_in_aer' => (!empty($config['hld_in_aer_factor_high']) && is_numeric($config['hld_in_aer_factor_high'])) ? $config['hld_in_aer_factor_high'] : 17.21, // maps to C25
      'drying_storage' => (!empty($config['drying_storage_factor_high']) && is_numeric($config['drying_storage_factor_high'])) ? $config['drying_storage_factor_high'] : 6.45 // maps to C26
    ];
  }

  /**
   * Method description.
   */
  public function doSomething()
  {
    // @DCG place your code here.
  }

  /**
   * Get the sume of a reprocessing costs array
   * @param array
   * @return float
   * */
  private function getSum($array)
  {
    $subtotal = 0;
    foreach ($array as $key => $value) {
      $subtotal += $value;
    }
    return $subtotal;
  }

  /**
   * Get an array of things the frontend needs
   * @return array
   */
  public function getPrep()
  {
    return [
      'reprocessingSums' => [
        'low' => $this->getSum($this->reprocessingCostsLow),
        'average' => $this->getSum($this->reprocessingCostsAverage),
        'high' => $this->getSum($this->reprocessingCostsHigh)
      ]
    ];
  }

  /**
   * Returns an array of calculated values
   * @param string $facilityName
   * @param int $totalProcedures
   * @param int $singleUseProcedures
   * @param int $bflexBroncoscopePrice
   * @param int $currentReusableQuantity
   * @param int $currentAnnualServicePer,
   * @param string $reprocessingCalcMethod,
   * @param int $currentAnnualOopRepairAllFactor
   * @return array An associative array with calculated values
   */
  public function calculate(
    $facilityName,
    $totalProcedures,
    $singleUseProcedures,
    $bflexBroncoscopePrice,
    $currentReusableQuantity,
    $currentAnnualServicePer,
    $reprocessingCalcMethod,
    $currentAnnualOopRepairAllFactor
  ) {

    $this->validateInputs(
      $totalProcedures,
      $singleUseProcedures,
      $bflexBroncoscopePrice,
      $currentReusableQuantity,
      $currentAnnualServicePer,
      $reprocessingCalcMethod,
      $currentAnnualOopRepairAllFactor
    );

    $this->facilityName = $facilityName;
    $this->totalProcedures = $totalProcedures;
    $this->singleUseProcedures = $singleUseProcedures;
    $this->proceduresRequiringReusable = $totalProcedures - $singleUseProcedures;
    $this->bflexBroncoscopePrice = $bflexBroncoscopePrice;
    $this->currentReusableQuantity = $currentReusableQuantity;
    $this->currentAnnualServicePer = $currentAnnualServicePer;
    $this->reprocessingCalcMethod = $reprocessingCalcMethod;
    $this->currentAnnualOopRepairAllFactor = $currentAnnualOopRepairAllFactor;

    // This is a stop-gap.  In the futute, this quantity will come in as an input.
    $this->reducingReusableScopes = $this->currentReusableQuantity;

    return [
      'current_annual_oop_repair_all_factor' => $this->currentAnnualOopRepairAllFactor,
      'facility_name' => $this->facilityName,
      'cost_per_infection' => self::COST_PER_INFECTION,
      'reprocessing_costs' => $this->getReprocessingCosts(),
      'current_costs' => $this->getCurrentCosts(),
      'reducing_costs' => $this->getReducingCosts(),
    ];
  }

  /**
   * Get reprocessing costs used for calculations
   * @return array
   */
  private function getReprocessingCosts()
  {
    return [
      'method' => $this->reprocessingCalcMethod,
      'details' => $this->getReprocessingArray()
    ];
  }

  /**
   * Get costs associated with "reducing" column
   * @return array associative array
   */
  private function getReducingCosts()
  {
    $equipmentCosts = $this->getReducingEquipmentCosts();
    $repairMaintenance = $this->getReducingRepairMaintenance();
    $reprocessing = $this->getReducingReprocessing();
    $treatingInfections = $this->getReducingTreatingInfections();
    $totalCosts =
      $equipmentCosts['total_su_bflex_cost'] +
      $repairMaintenance['total_annual_maint_repair'] +
      $reprocessing['total_annual_reprocessing_costs'] +
      $treatingInfections['annual_costs'];
    return [
      'equipment_costs' => $equipmentCosts,
      'repair_maintenance' => $repairMaintenance,
      'reprocessing' => $reprocessing, // same as "maintaining" column
      'treating_infections' => $treatingInfections, // same as "maintaining" column
      'total_costs' => (int) $totalCosts, // maps to F33
    ];
  }

  private function getReducingEquipmentCosts()
  {
    return [
      'single_use_scopes' => $this->singleUseProcedures,
      'total_su_bflex_cost' => $this->singleUseProcedures * $this->bflexBroncoscopePrice // maps to F12
    ];
  }

  /**
   * Gets "reducing" column repair and maintenance costs
   */
  private function getReducingRepairMaintenance()
  {
    $oopRepairAll = $this->getAnnualOopRepairAll() * ($this->proceduresRequiringReusable / $this->totalProcedures);
    return [
      'reusable_scopes_quantity' => $this->reducingReusableScopes,
      'service_agreement_per_bronchoscope' => $this->currentAnnualServicePer,
      'annual_oop_repair_all' => intval($oopRepairAll), // maps to F16
      'total_annual_maint_repair' => intval(($this->currentAnnualServicePer * $this->reducingReusableScopes) + $oopRepairAll), // maps to F17
    ];
  }

  /**
   * Gets costs for treating infections under "reducing" column
   * @return array
   */
  private function getReducingTreatingInfections()
  {
    $patientInfections = $this->getInfectionsFromProcedures($this->proceduresRequiringReusable);
    $annualCosts = $patientInfections * self::COST_PER_INFECTION;
    return [
      'patient_infections' => (float) number_format($patientInfections, 2), // maps to E29
      'annual_costs' => round($annualCosts)
    ];
  }

  /**
   * Get reprocessing costs for "Reducing" column.
   * @return array associative array
   */
  private function getReducingReprocessing()
  {
    $baseCost = $this->getSumReprocessingCosts();
    return [
      'total_annual_reprocessing_costs' => round($baseCost * ($this->totalProcedures - $this->singleUseProcedures)) // maps to F27
    ];
  }

  /**
   * Retrieve an array of current costs based off client inputs
   * @return array associative array
   */
  private function getCurrentCosts()
  {
    $currentEquipmentCosts = $this->getCurrentEquipmentCosts();
    $currentRepairMaintenance = $this->getCurrentRepairMaintenance();
    $currentReprocessing = $this->getCurrentReprocessing();
    $treatingInfections = $this->getCurrentTreatingInfections();
    $totalCosts =
      $currentEquipmentCosts['total_su_bflex_cost'] +
      $currentRepairMaintenance['total_annual_maint_repair'] +
      $currentReprocessing['total_annual_reprocessing_costs'] +
      $treatingInfections['annual_costs'];

    return [
      'equipment_costs' => $currentEquipmentCosts,
      'repair_maintenance' => $currentRepairMaintenance,
      'reprocessing' => $currentReprocessing,
      'treating_infections' => $treatingInfections,
      'total_costs' => (int) $totalCosts, // maps to C33
    ];
  }

  /**
   * Gets an array of current equipment costs
   * @return array associative array
   */
  private function getCurrentEquipmentCosts()
  {
    return [
      'single_use_scopes' => self::CURRENT_SU_BLEX_USAGE,
      'total_su_bflex_cost' => $this->getCurrentTotalBFlexCost()
    ];
  }

  /**
   * Get total BFlex cost for "Current" column
   * @return int
   */
  private function getCurrentTotalBFlexCost()
  {
    return self::CURRENT_SU_BLEX_USAGE * $this->bflexBroncoscopePrice; // maps to C12
  }

  private function getInfectionsFromProcedures($procedures)
  {
    return $procedures * .034 * .2125;
  }

  /**
   * Retrieve an array of current infection costs
   * @return array associative array
   */
  private function getCurrentTreatingInfections()
  {
    $patientInfections = $this->getInfectionsFromProcedures($this->totalProcedures);
    $annualCosts = self::COST_PER_INFECTION * $patientInfections;
    return [
      'patient_infections' => (float) number_format($patientInfections, 2), // maps to C29
      'annual_costs' => (int) round($annualCosts) // maps to C31
    ];
  }

  /**
   * Sums up all the reprocessing costs based on the calculation method
   * @return int
   */
  private function getSumReprocessingCosts()
  {
    $costs = $this->getReprocessingArray();
    $baseCost = 0;
    foreach ($costs as $key => $cost) {
      $baseCost += $cost;
    }
    return $baseCost;
  }

  /**
   * Return an array of reprocessing costs based on the calc method
   * @return array
   */
  private function getReprocessingArray()
  {
    if ($this->reprocessingCalcMethod == 'average') {
      $costs = $this->reprocessingCostsAverage;
    } else if ($this->reprocessingCalcMethod == 'low') {
      $costs = $this->reprocessingCostsLow;
    } else if ($this->reprocessingCalcMethod == 'high') {
      $costs = $this->reprocessingCostsHigh;
    } else {
      throw new \Exception('Unsupported reprocessing calculation method.');
    }
    return $costs;
  }

  /**
   * Retrieve an array of current reprocessing costs
   * @return array associative array
   */
  private function getCurrentReprocessing()
  {
    $baseCost = $this->getSumReprocessingCosts();

    return [
      'total_annual_reprocessing_costs' => $baseCost * $this->totalProcedures
    ];
  }

  /**
   * Calculate annual out of pocket repair costs for all columns
   * @return int
   */
  private function getAnnualOopRepairAll()
  {
    return $this->currentAnnualOopRepairAllFactor * $this->totalProcedures;
  }

  /**
   * Retrieve an array of current repair and maintenance costs
   * @return array associative array
   */
  private function getCurrentRepairMaintenance()
  {
    $annualOopRepairAll = $this->getAnnualOopRepairAll();
    $totalAnnualMaintRepair = ($this->currentAnnualServicePer * $this->currentReusableQuantity) + $annualOopRepairAll;

    return [
      'reusable_scopes_quantity' => $this->currentReusableQuantity,
      'service_agreement_per_bronchoscope' => $this->currentAnnualServicePer,
      'annual_oop_repair_all' => $annualOopRepairAll, // maps to C16
      'total_annual_maint_repair' => $totalAnnualMaintRepair, // maps to C17
    ];
  }

  /**
   * Validates inputs and throws and exception on failure.
   * @param int $totalProcedures
   * @param int $singleUseProcedures
   * @param int $bflexBroncoscopePrice
   * @param int $currentReusableQuantity
   * @param int $currentAnnualServicePer
   * @param string $reprocessingCalcMethod
   * @param string $currentAnnualOopRepairAllFactor
   * @throws Exception if input is invalid.
   */
  private function validateInputs(
    $totalProcedures,
    $singleUseProcedures,
    $bflexBroncoscopePrice,
    $currentReusableQuantity,
    $currentAnnualServicePer,
    $reprocessingCalcMethod,
    $currentAnnualOopRepairAllFactor
  ) {
    $errors = [];
    if (!is_int($totalProcedures)) {
      $errors[] = 'Total Procedures must be an integer.';
    }
    if ($totalProcedures < 1) {
      $errors[] = 'Total Procedures must be greater than 0.';
    }
    if (!is_int($totalProcedures)) {
      $errors[] = 'Single-Use Procedures must be an integer.';
    }
    if ($totalProcedures < 1) {
      $errors[] = 'Single-Use Procedures must be greater than 0.';
    }
    if ($bflexBroncoscopePrice < 1) {
      $errors[] = 'Bflex Bronchoscope Price must be greater than 0.';
    }
    if (!is_int($currentReusableQuantity)) {
      $errors[] = 'Current Resusable Quantity must be an integer.';
    }
    if ($currentReusableQuantity < 1) {
      $errors[] = 'Current Resusable Quantity must be greater than 0.';
    }
    if (!is_int($currentAnnualServicePer)) {
      $errors[] = 'Current Annual Service Per must be an integer.';
    }
    if ($currentAnnualServicePer < 1) {
      $errors[] = 'Current Annual Service Per must be greater than 0.';
    }
    if ($reprocessingCalcMethod !== 'low' && $reprocessingCalcMethod !== 'average' && $reprocessingCalcMethod !== 'high') {
      $errors[] = 'Reprocessing Calculation Method must be "low", "average", or "high".';
    }
    if (!is_int($currentAnnualOopRepairAllFactor)) {
      $errors[] = 'Current Annual OOP Repair All Factor must be an integer.';
    }

    if (count($errors)) {
      throw new \Exception('An error occured while processing the form. ' . implode(' ', $errors));
    }
  }

  /**
   * @method
   * This method returns a mock response of the calculator.
   */
  public function getMock()
  {
    try {
      $results = $this->calculate('My Facility', 1000, 750, 265, 30, 2200, 'low', 53);
      return $results;
      $results = [
        'current_annual_oop_repair_all_factor' => 53,
        'facility_name' => 'My Facility',
        'cost_per_infection' => 28383,
        'reprocessing_costs' => [
          'method' => 'low',
          'details' => [
            'ppe_personal' => 5.06,
            'bedside_preclean' => 4.45,
            'leak_testing' => 2.27,
            'manual_cleaning' => 11.12,
            'visual_inspection' => 14.62,
            'hld_in_aer' => 10.74,
            'drying_storage' => 1.88
          ]
        ],
        'current_costs' => [
          'equipment_costs' => [
            'single_use_scopes' => 0,
            'total_su_bflex_cost' => 0
          ],
          'repair_maintenance' => [
            'reusable_scopes_quantity' => 30,
            'service_agreement_per_bronchoscope' => 2200,
            'annual_oop_repair_all' =>  53000,
            'total_annual_maint_repair' => 119000,
          ],
          'reprocessing' => [
            'total_annual_reprocessing_costs' => 50140
          ],
          'treating_infections' => [
            'patient_infections' => 7.23,
            'annual_costs' => 205067,
          ],
          'total_costs' => 374207,
        ],
        'reducing_costs' => [
          'equipment_costs' => [
            'single_use_scopes' => 750,
            'total_su_bflex_cost' => 198750
          ],
          'repair_maintenance' => [
            'reusable_scopes_quantity' => 30,
            'service_agreement_per_bronchoscope' => 2200,
            'annual_oop_repair_all' => 13250,
            'total_annual_maint_repair' => 79250
          ],
          'reprocessing' => [
            'total_annual_reprocessing_costs' => 12535
          ],
          'treating_infections' => [
            'patient_infections' => 1.81,
            'annual_costs' =>  51267
          ],
          'total_costs' =>  341802
        ],
      ];
      return $results;
    } catch (\Exception $e) {
      return [];
    }
  }
}
